<?php
// Application middleware

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->add(function(Request $request, Response $response, callable $next) {

	// Docs tidak perlu di-log
	if ("/docs" === $request->getUri()->getPath()) {		
		$response = $next($request, $response);
		return $response;	
	}
	
	//$accessKey = (isset($request->getHeaders()['HTTP_ACCESS_KEY'][0])? $request->getHeaders()['HTTP_ACCESS_KEY'][0] : "Unknown");

    //$this->get('logger')->info("[".$accessKey."] ".$request->getMethod()." ".$request->getUri()->getPath(). " [header : ".json_encode($request->getHeaders())."\n body: ".json_encode($request->getParsedBody())."]");
    
    $response = $next($request, $response);
    
    //$this->get('logger')->info("[".$accessKey."] ".$response->getStatusCode(). " [header : ".json_encode($response->getHeaders())."\n body: ".(string)($response->getBody())."]");

    return $response;
});