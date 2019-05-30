<?php
namespace App\manage;

use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\base\BaseController;

/**
 * Note: Sebaiknya path untuk cache menggunakan Basic Auth agar tidak dapat diakses oleh aplikasi lain 
 *
 * @INVISIBLE: false
 */
class CacheController extends BaseController
{

	
	/**
	 * GROUP LIST
	 *
	 * @DESCRIPTION Daftar cache group
	 *
	 * @RETURN Model::Response->Array-><small>{"[group]":{"limit": [limit],"expiration": [expiration],"nullable":[nullable]}</small>
	 * 
	 * @PUBLIC: true
	 * 	 	
	 */
	public function group__list() {
		$request = $this->getRequest();
		$data = $this->getCache()->groups();
		return Result::SUCCESS($data);
	}

	/**
	 * GROUP CLEAR
	 *
	 * @DESCRIPTION Membersihkan semua data dalam group
	 *
	 * @PARAMETER group => ID group
	 *
	 * @RETURN Model::Response->SUCCESS / ERROR
	 * 
	 * @PUBLIC: true
	 * 	 	
	 */
	public function group__clear() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$this->getCache()->clear($group);
		return Result::SUCCESS();
	}

	/**
	 * GROUP KEYS
	 *
	 * @DESCRIPTION Daftar key dalam cache group
	 *
	 * @PARAMETER group => Group
	 *
	 * @RETURN Model::Response->SUCCESS / ERROR
	 * 
	 * @PUBLIC: true
	 * 	 	
	 */
	public function group__keys() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$data = $this->getCache()->keys($group);
		return Result::SUCCESS($data);
	}


	/**
	 * GROUP KEY REMOVE
	 *
	 * @DESCRIPTION Membuang key dari dalam cache group
	 *
	 * @PARAMETER group => Group
	 * @PARAMETER key => Key
	 *
	 * @RETURN Model::Response->SUCCESS / ERROR
	 * 
	 * @PUBLIC: true
	 * 	 	
	 */
	public function group__key__remove() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$key = $request->getParam("key");
		$this->getCache()->remove($group, unserialize($key));
		return Result::SUCCESS();
	}
}