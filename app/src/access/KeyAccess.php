<?php
namespace App\access;

use \Exception;
use \ReflectionMethod;

use \Psr\Http\Message\ServerRequestInterface as Request;

use \Ideahut\sdms\object\Result;

use \Ideahut\sdms\util\ObjectUtil;
use \Ideahut\sdms\util\RequestUtil;

use \App\Project;

use \App\entity\Access;
use \App\entity\User;

class KeyAccess
{

	private static $PARAMETER_ACCESS_KEY	= "p_access";
	private static $HEADER_ACCESS_KEY		= "Access-Key";


	private $controller;

	private $parameter = [];

	public function __construct() {
    	$argv = func_get_args();
    	$narg = func_num_args();
    	if ($narg > 0) {
    		$this->controller($argv[0]);
    	}
    	if ($narg > 1) {
    		$this->parameter($argv[1]);
    	}
    }

    public function controller() {
    	if (func_num_args() === 0) {
            return $this->controller;
        }
        $this->controller = func_get_args()[0];
        return $this;
    }

    public function parameter() {
    	if (func_num_args() === 0) {
            return $this->parameter;
        }
        $this->parameter = func_get_args()[0];
        return $this;
    }

	/*
	 * VALIDATE
	 */	
	public function validate($access_rule, ReflectionMethod $method = null) {
		if (isset($access_rule) && $access_rule->public === true) {
			return null;
		}

		$request = $this->controller->getRequest();
	    
	    $key = $this->key();
	    $key = isset($key) ? trim($key) : "";
	    if ($key === "") {
        	return Result::ERROR(Result::ERR_REQUIRED, "Access Key");
    	}
		
		$data = $this->data();
		if (!isset($data)) {
        	return Result::ERROR(Result::ERR_NOT_FOUND, "Access");
    	}
	    
	    $validation = $this->unique();
	    if ($validation !== $data->validation) {
	        return Result::ERROR(Result::ERR_INVALID, "Access");
	    }
	    
	    if ($data->hasExpired()) {
	        $this->revoke();
	        return Result::ERROR(Result::ERR_EXPIRED, "Access");
	    }

	    $must_login = isset($access_rule) && $access_rule->login === true;
	    if ($must_login && !isset($data->user)) {
	    	return Result::ERROR("40", "User is not login");
	    }
	    return null;	    
	}


	/*
	 * KEY
	 */
	public function key() {
		return self::getAccessKey($this->controller->getRequest());
	}

	/*
	 * DATA
	 */
	public function data() {
		$ctr = $this->controller;
		return self::getAccessData(
			$ctr->getEntityManager(),
			$ctr->getCache(),
			$ctr->getLogger(),
			$ctr->getRequest()
		);
	}

	/*
	 * REVOKE
	 */
	public function revoke() {
		$ctr = $this->controller;
		return self::delAccessData(
			$ctr->getEntityManager(),
			$ctr->getCache(),
			$ctr->getLogger(),
			$ctr->getRequest()
		);
	}


	/*
	 * CREATE
	 */
	public function create() {
		$user = null;
		$is_user   = false;
    	$is_extend = false;
    	$is_renew  = false;
    	if (func_num_args() > 0) {
    		$argv = func_get_args();
    		if (is_bool($argv[0])) {
    			$is_extend = $argv[0];
    		} else if (is_integer($argv[0])) {
    			$is_renew = true;
    		} else if (null === $argv[0] || $argv[0] instanceof User) {
    			$user = $argv[0];
    			$is_user = true;	
    		}
    	}
		$controller = $this->controller;
		$request    = $controller->getRequest();
		$exp_in_sec = 10800; // default 3 jam
		if (isset($this->parameter["EXPIRATION_IN_SECOND"])) {
			$exp_in_sec = (int)$this->parameter["EXPIRATION_IN_SECOND"];
		}
		
		$key = $this->key();
		$key = isset($key) ? trim($key) : "";		
		$dao = Access::dao($controller->getEntityManager(), $controller->getLogger());
		$result = null;
		if ($key === "" || $is_renew) {
			$expiration = round(microtime(true) * 1000) + ($exp_in_sec * 1000);
			$validation = $this->unique();
			$result = $dao->value([
						"user" => $user,
						"expiration" => $expiration,
						"validation" => $validation,
					])->save();
		} else {
			$controller->getCache()->remove(Project::CACHE_ACCESS, $key);
			$result = $dao->pk($key)->get();
			if (!isset($result)) {
				return null;	
			}
			if ($is_extend) {
				$expiration = round(microtime(true) * 1000) + ($exp_in_sec * 1000);
				$result->expiration = $expiration;
				$result->save($controller->getEntityManager());
			} else if ($is_user) {
				$result->user = $user;
				$result->save($controller->getEntityManager());
			}
		}
		return $result;
	}

	/*
	 * UNIQUE
	 */
	public function unique() {
		return self::getUnique($this->controller->getRequest());
	}






	public static function getAccessKey(Request $request) {
		$result = $request->getHeaderLine(self::$HEADER_ACCESS_KEY);
		if (isset($result)) {
			return $result;
		}
		$result = $request->getHeaderLine(strtolower(self::$HEADER_ACCESS_KEY));
		if (isset($result)) {
			return $result;
		}
		$result = $request->getParam(self::$PARAMETER_ACCESS_KEY);
		return $result;
	}

	public static function getUnique(Request $request) {
		$result = RequestUtil::getRemoteAddr($request) . " " . RequestUtil::getUserAgent($request);
		return $result;
	}

	public static function getAccessData($manager, $cache, $logger, $request) {
		$key = self::getAccessKey($request);
	    $key = isset($key) ? trim($key) : "";
	    if ($key === "") {
			return null;
		}
		return $cache->get(Project::CACHE_ACCESS, $key, function($args) {
			$access = Access::dao($args[0], $args[1])->pk($args[2])->get();
			if (isset($access)) {
				// Buat Object Access baru untuk menghindari error serialize proxy ke cache
				$result = new Access();
				ObjectUtil::copy($access, $result, ObjectUtil::PROPERTY, ["user"]);
				if (isset($access->user)) {
					$user = new User();
					ObjectUtil::copy($access->user, $user);
					$result->user = $user;
				}
				return $result;
			}
			return null;
		}, [$manager, $logger, $key]);
	}

	public static function delAccessData($manager, $cache, $logger, $request) {
		$key = self::getAccessKey($request);
	    $key = isset($key) ? trim($key) : "";
	    if ($key === "") {
			return false;
		}
		$cache->remove(Project::CACHE_ACCESS, $key);
		$deleted = Access::dao($manager, $logger)->pk($key)->delete();
		return $deleted !== 0;
	}

}