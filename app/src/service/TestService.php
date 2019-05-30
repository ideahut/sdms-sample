<?php
namespace App\service;

use \Exception;

use \Ideahut\sdms\base\BaseService;
use \Ideahut\sdms\object\CodeMsg;
use \Ideahut\sdms\object\Result;

class TestService extends BaseService
{
	public function halo() {
		return "OLAH";
	}

	public function add($a, $b) {
		if (is_int($a) && is_int($b)) {
			return $a + $b;	
		}
		throw new Exception("Invalid integer");		
	}

	public function code() {
		return new CodeMsg("XX", "OK");
	}

	public function text($text) {
		return Result::SUCCESS($text); 
	}
}