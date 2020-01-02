<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->configsDir,
        $config->application->controllersDir,
        $config->application->viewsDir,
    ]
);

$loader->registerNamespaces(
    [
        'App\Phalcon\Models'        => $config->application->modelsDir,
        'App\Phalcon\Configs'       => $config->application->configsDir,
        'App\Phalcon\Controllers'   => $config->application->controllersDir,
    ]
);

$loader->register();

include __DIR__ . '/../../vendor/autoload.php';