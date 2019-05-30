<?php
namespace App\access;

use \Psr\Http\Message\ServerRequestInterface as Request;

use \Ideahut\sdms\Common;
use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\util\RequestUtil;

use \App\Project;
use \App\entity\User;

class AdminAccess
{

	private $parameter;

	public function __construct() {
    	$this->parameter(func_get_args());
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
	public function validate(Request $request, $app, $args) {
        $appcont = $app->getContainer();
        $manager = $appcont[Common::SETTING_ENTITY_MANAGER];
        $cache   = $appcont[Common::SETTING_CACHE];
        $logger  = $appcont[Common::SETTING_LOGGER];
        $access  = KeyAccess::getAccessData($manager, $cache, $logger, $request);
        if (!isset($access)) {
            return Result::ERROR(Result::ERR_REQUIRED, "Access");
        }
        $validation = KeyAccess::getUnique($request);
        if ($validation !== $access->validation) {
            return Result::ERROR(Result::ERR_INVALID, "Access");
        }        
        if ($access->hasExpired()) {
            KeyAccess::delAccessData($manager, $cache, $logger, $request);
            return Result::ERROR(Result::ERR_EXPIRED, "Access");
        }
        $user = $access->user;
        if (!isset($user) || $user->role !== User::ROLE_ADMIN) {
            return Result::ERROR(Result::ERR_NOT_ALLOWED, "Access");   
        }
        return null;
	}
}