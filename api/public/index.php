<?php

error_reporting(E_ALL);

try {
    $config = require __DIR__ . '/../src/Configs/config.php';

    require_once __DIR__ . '/../src/Configs/loader.php';

    require_once __DIR__ . '/../src/Configs/services.php';

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle($_SERVER["REQUEST_URI"])->getContent();

} catch (\Phalcon\Mvc\Application\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
} catch (Phalcon\Mvc\Dispatcher\Exception $e) {
    print "APP_ERROR: " . $e->getTraceAsString();
}