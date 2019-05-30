<?php
namespace App\controller;

use \Ideahut\sdms\base\BaseController;
use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\util\RequestUtil;

use \App\entity\User;

class AccessController extends BaseController
{

	/**
     * KEY
     *
     * @DESCRIPTION Membuat atau meng-update Access Key.
     * @DESCRIPTION Untuk memperpanjang yang lama, sertakan Access Key di header.
     * @RETURN Entity::Result->Entity::Access
     * @METHOD post, get
     * @PUBLIC
     */
	public function key() {
		$access = $this->getAccess();
		if (!isset($access)) {
			return Result::ERROR(Result::ERR_NOT_FOUND, "Access setting");
		}
		$result = $access->data();
		if (!isset($result) || $result->hasExpired()) {
			$access->revoke();
			$result = $access->create();
			if (!isset($result)) {
				return Result::ERROR(Result::ERR_NOT_FOUND, "Access Key");
			}
		} else {               
			$validation = $access->unique();
			if ($validation !== $result->validation) {
				return Result::ERROR(Result::ERR_INVALID, "Access");
			} 
			$result = $access->create(true);
		}
		if (isset($result)) {
			$result->user 		= null;
			$result->expiration = null;
			$result->validation = null;
		}
		return Result::SUCCESS($result);
	}
	
	
	/**
     * INFO
     *
     * @DESCRIPTION Mendapatkan data akses, seperti: user, dll.
     * @RETURN Entity::Result->Entity::Access
     * @METHOD post, get
     */
	public function info() {
		$result = $this->getAccess()->data();
		if (isset($result)) {
			$result->expiration = null;
			$result->validation = null;
		}
		return Result::SUCCESS($result);
	}
	

	/**
	 * LOGIN
	 * 
	 * @DESCRIPTION Login
	 * @PARAMETER username => Nama pengguna
	 * @PARAMETER authcode => Kode otentikasi SHA256(AccessKey + username + SHA256(password))
	 * @RETURN Entity::Result->Entity::Access
	 * @METHOD post
	 * @VALIDATOR AccessValidator->login
	 * @NOUSER
	 */
	public function login() {
		$request = $this->getRequest();
		if (($validator = RequestUtil::validate($this, __METHOD__)) !== null) return $validator;

		$username = $request->getParam("username");
		$access   = $this->getAccess();

		$dao  = User::objects($this);
		$user = $dao->filter(["username" => $username])->get();
		if (!isset($user)) {
			return Result::ERROR(Result::ERR_NOT_FOUND, "User");
		}

		$authcode = hash("sha256", $access->key() . $user->username . $user->password);
		if ($request->getParam("authcode") !== $authcode) {
			return Result::ERROR(Result::ERR_INVALID, "Password");
		}
		switch ($user->status) {
			case User::STATUS_INACTIVE:
				return Result::ERROR(Result::ERR_NOT_ACTIVE, "User");		
				break;
			case User::STATUS_SUSPENDED:
				return Result::ERROR("20", "User is suspended");		
				break;
		}
		$result = $access->create($user);
		if (isset($result)) {
			$result->expiration = null;
			$result->validation = null;
		}
		return Result::SUCCESS($result);
	}


	/**
	 * LOGOUT
	 * 
	 * @DESCRIPTION Logout dengan menyertakan Access Key	 
	 * @RETURN Entity::Result->Entity::Access
	 * @METHOD post, get	 
	 */
	public function logout() {
		$access = $this->getAccess();
		$result = $access->create(null);
		if (isset($result)) {
			$result->expiration = null;
			$result->validation = null;
		}
		return Result::SUCCESS($result);
	}


	/**
	 * RENEW
	 * 
	 * @DESCRIPTION Mengganti Access Key lama dengan yang baru
	 * @RETURN Entity::Result->Entity::Access
	 * @METHOD post, get	 
	 * @NOUSER
	 */
	public function renew() {
		$access = $this->getAccess();
		$access->revoke();
		$result = $access->create(0);
		if (isset($result)) {
			$result->expiration = null;
			$result->validation = null;
		}
		return Result::SUCCESS($result);
	}

}