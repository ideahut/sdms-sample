<?php
use \Ideahut\sdms\Common;


// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container[Common::SETTING_LOGGER] = function ($c) {
    $settings = $c->get(Common::SETTING_SETTINGS);
    $logger = new \Monolog\Logger($settings[Common::SETTING_LOGGER]['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    //$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
	$logger->pushHandler(new \Monolog\Handler\RotatingFileHandler(
		$settings[Common::SETTING_LOGGER]['path'], 
		$settings[Common::SETTING_LOGGER]['level'])
	);
    return $logger;
};

// Doctrine
$container[Common::SETTING_ENTITY_MANAGER] = function ($c) {
    $settings = $c->get(Common::SETTING_SETTINGS);
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    $doctrine = \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
    return $doctrine;
};

// Cache
$container[Common::SETTING_CACHE] = function ($c) {
    $settings = $c->get(Common::SETTING_SETTINGS);
	$config = $settings[Common::SETTING_CACHE];
    return \Ideahut\sdms\cache\Cache::create($config);
};

