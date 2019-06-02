<?php
date_default_timezone_set("Asia/Jakarta");

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

//session_start();

// Get settings
if (extension_loaded('apcu') && false) { // Ganti jadi true jika ingin disimpan dicache
	$settings = apcu_fetch("___SETTINGS___");
	if ($settings === false) {
		$settings = require __DIR__ . '/../app/settings.php';
		apcu_store("___SETTINGS___", $settings);
	}	
} else {
	$settings = require __DIR__ . '/../app/settings.php';
}

// Ideahut sdms init
\Ideahut\sdms\Common::init([
	"settings"=> $settings
]);

// Instantiate the app
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
//require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';


// Run!
$app->run();
