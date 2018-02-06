<?php

use Phalcon\Loader;

/**
 * Registering an autoloader.
 */
$loader = new Loader();

$loader->registerDirs([
    $config->application->appDir,
    $config->application->tasksDir,
    $config->application->modelsDir,
    $config->application->controllersDir,
    $config->application->libsDir,
    $config->application->interfacesDir,
    $config->application->constantsDir
]);


$loader->registerNamespaces([
    'App' => $config->application->appDir,
    'App\Task' => $config->application->tasksDir,
    'App\Controller' => realpath(__DIR__. '/../controller'),
    'App\Constants' => realpath(__DIR__. '/../constants'),
    'App\Model' => realpath(__DIR__. '/../model')
])->register();
