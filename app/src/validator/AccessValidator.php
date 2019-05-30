<?php
namespace App\validator;

use \Respect\Validation\Validator as v;

final class AccessValidator {
	
	/**
     * LOGIN
     *
     */
    public function login() {
        return [
            'username'  => ['rules' => v::notEmpty(), 'messages' => ["notEmpty" => "username harus diinput"]],
            'authcode' 	=> ['rules' => v::notEmpty(), 'messages' => ["notEmpty" => "authcode harus diinput"]],
        ];
    }
}