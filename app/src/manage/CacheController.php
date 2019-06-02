<?php
namespace App\manage;

use \Ideahut\sdms\object\Result;
use \Ideahut\sdms\base\BaseController;

use \Ideahut\sdms\annotation as IDH;


/**
	Note: Sebaiknya path untuk cache menggunakan Basic Auth agar tidak dapat diakses oleh aplikasi lain 

 	@IDH\Document(ignore = true)
 */
class CacheController extends BaseController
{

	/**
	 	@IDH\Document(
     		description = "List of cache group",
     		result = {Result::class, "Array", "group: limit, expiration, nullable"}
	 	)
	 	@IDH\Method({"GET", "POST"})
	 	@IDH\Access(public = true)
     */
	public function group__list() {
		$request = $this->getRequest();
		$data = $this->getCache()->groups();
		return Result::SUCCESS($data);
	}

	/**
	 	@IDH\Document(
     		description = "Clear all data in a group",
     		parameter = {
				@IDH\Parameter(name = "group", description = "Group name", type = "string")
     		},
     		result = {Result::class, "SUCCESS / ERROR"}
	 	)
	 	@IDH\Method({"POST"})
	 	@IDH\Access(public = true)
     */
	public function group__clear() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$this->getCache()->clear($group);
		return Result::SUCCESS();
	}

	/**
	 	@IDH\Document(
     		description = "Get all data keys in a group",
     		parameter = {
				@IDH\Parameter(name = "group", description = "Group name", type = "string")
     		},
     		result = {Result::class, "Array", "Key"}
	 	)
	 	@IDH\Method({"POST"})
	 	@IDH\Access(public = true)
     */
	public function group__keys() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$data = $this->getCache()->keys($group);
		return Result::SUCCESS($data);
	}

	/**
	 	@IDH\Document(
     		description = "Remove data from a group",
     		parameter = {
				@IDH\Parameter(name = "group", description = "Group name", type = "string"),
				@IDH\Parameter(name = "key", description = "Data key", type = "mixed")
     		},
     		result = {Result::class, "SUCCESS / ERROR"}
	 	)
	 	@IDH\Method({"POST"})
	 	@IDH\Access(public = true)
     */
	public function group__key__remove() {
		$request = $this->getRequest();
		$group = $request->getParam("group");
		$key = $request->getParam("key");
		$this->getCache()->remove($group, unserialize($key));
		return Result::SUCCESS();
	}
}