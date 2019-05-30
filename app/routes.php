<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \Ideahut\sdms\Common;
use \Ideahut\sdms\util\RoutesUtil;
use \Ideahut\sdms\util\AdminUtil;
use \Ideahut\sdms\util\DocsUtil;
use \Ideahut\sdms\util\HessianUtil;


/**
 * CORS
 *
 */
$app->options('/{routes:.+}', function ($request, $response, $args) {
	return $response;
});
$app->add(function ($req, $res, $next) use ($app) {
	$response = $next($req, $res);
	$settings = $app->getContainer()[Common::SETTING_SETTINGS];
	return $response
	->withHeader('Access-Control-Allow-Origin', $settings[Common::SETTING_CORS_ORIGIN])
	->withHeader('Access-Control-Allow-Methods', $settings[Common::SETTING_CORS_METHODS])
	->withHeader('Access-Control-Allow-Headers', $settings[Common::SETTING_CORS_HEADERS]);
});


/**
 * Format:
 * Path Index 1: untuk mengarahkan ke class Controller dengan merubah huruf depan menjadi huruf besar, cth: /role/a/b -> RoleController
 * Path Index selanjutnya akan lookup (invoke) method, dimana '/' direplace dengan '__', cth: /role/a/b -> RoleController::a__b()
 */
if (isset($app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_ROUTE])) {
	$configs = $app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_ROUTE];
	foreach ($configs as $config) {
		$app->map(
			['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'TRACE', 'PATCH', 'CONNECT'], 
			$config[Common::SETTING_PATH], 
			function(Request $request, Response $response, $args) use ($app, $config) {
				return RoutesUtil::process($app, $config, $request, $response, $args);
			}
		);
	}    
}


/**
 * ADMIN
 * 
 */
if (isset($app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_ADMIN])) {
	$app->map(
		['POST'], 
		'/admin/[{path:.*}]', 
		function(Request $request, Response $response, $args) use ($app) {
			return AdminUtil::process($app, $request, $response, $args);
		}
	);
}


/**
 * DOCUMENTATION
 * 
 */
if (isset($app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_DOCUMENT])) {
	$app->map(
		['POST', 'GET'], 
		'/docs', 
		function(Request $request, Response $response, $args) use ($app) {
	    	return DocsUtil::html($app, $request, $response, $args);
		}
	);
}


/**
 * HESSIAN
 * 
 */
if (isset($app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_HESSIAN])) {
	$config = $app->getContainer()[Common::SETTING_SETTINGS][Common::SETTING_HESSIAN];
	$app->post(
		'/hessian/[{path:.*}]', 
		function(Request $request, Response $response, $args) use ($app, $config) {
			return HessianUtil::process($app, $config, $request, $response, $args);
		}
	);
}


/**
 * PRINT ALL REQUEST OBJECT
 */
$app->map(
	['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'TRACE', 'PATCH', 'CONNECT'], 
	'/info/[{path:.*}]', 
	function(Request $request, Response $response, $args) use ($app) {
		return RoutesUtil::info($request, $response, $app, $args);
	}
);