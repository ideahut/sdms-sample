<?php
namespace App\iface;

use \Ideahut\sdms\refproxy\InvocationHandler;

class IFaceHandler implements InvocationHandler
{
    function invoke($proxy, $method, $args)
    {
    	return $method;
    }
}