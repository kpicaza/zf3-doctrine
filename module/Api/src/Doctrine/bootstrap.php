<?php

/**
 * Define application environment
 */
$env = (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production');
defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);

use Api\Module;

$config = include __DIR__ . '/../../config/module.config.php';
$doctrine = $config['doctrine'];

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require __DIR__ . '/../../../../vendor/autoload.php';

$isDevMode = (APPLICATION_ENV === 'production' ? true : false);
$config = Setup::createAnnotationMetadataConfiguration(
    array(__DIR__ . '/../Models'),
    $isDevMode
);

$entityManager = EntityManager::create($doctrine, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);