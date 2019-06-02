<?php
namespace App\controller;

use \Ideahut\sdms\base\BaseController;
use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\util\RequestUtil;

use \App\entity\Access;
use \App\entity\User;

use \Ideahut\sdms\annotation as IDH;

class AccessController extends BaseController
{

	/**
	 	@IDH\Document(
     		description = "Membuat atau meng-update Access Key. <br/>Untuk memperpanjang yang lama, sertakan Access Key di header.",
			result = {Result::class, Access::class}
	 	)
	 	@IDH\Method({"POST", "GET"})
     	@IDH\Access(public = true)
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
	 	@IDH\Document(
     		description = "Mendapatkan data akses, seperti: user, dll.",
			result = {Result::class, Access::class}
	 	)
	 	@IDH\Method({"POST", "GET"})
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
	 	@IDH\Document(
     		description = "Login dengan menyertakan Access Key",
     		parameter = {
				@IDH\Parameter(name = "username", description = "Nama pengguna", type = "string"),
				@IDH\Parameter(name = "authcode", description = "Kode otentikasi SHA256(AccessKey + username + SHA256(password))", type = "string")
     		},
     		result = {Result::class, Access::class}
	 	)
	 	@IDH\Method({"POST"})
	 	@IDH\Access(login = false)
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
	 	@IDH\Document(
     		description = "Logout dengan menyertakan Access Key",
     		result = {Result::class, Access::class}
	 	)
	 	@IDH\Method({"POST", "GET"})
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
	 	@IDH\Document(
     		description = "Mengganti Access Key lama dengan yang baru",
     		result = {Result::class, Access::class}
	 	)
	 	@IDH\Method({"POST", "GET"})
	 	@IDH\Access(login = false)
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