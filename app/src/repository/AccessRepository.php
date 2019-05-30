<?php
namespace App\repository;

use \Ideahut\sdms\repository\CrudRepository;

abstract class AccessRepository implements CrudRepository 
{
	private $dao;

	private function __dao__($dao) {
		$this->dao = $dao;		
	}

	public function counter($x1, $x2 = null) {
		return $this->dao->count();
	}

	abstract function getByKey($key);

}