<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\Common\Annotations\AnnotationReader;

use \Ideahut\sdms\Common;

require 'vendor/autoload.php';

$settings = include 'app/settings.php';
$settings = $settings['settings']['doctrine'];

Common::init();

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);
