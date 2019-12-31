<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->configsDir,
    ]
);

$loader->registerNamespaces(
    [
        'App\Phalcon\Models' => $config->application->modelsDir,
        'App\Phalcon\Configs' => $config->application->configsDir,
    ]
);

$loader->register();