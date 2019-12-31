<?php

$config = require __DIR__ . '/src/Configs/config.php';
require __DIR__ . '/src/Configs/loader.php';
require __DIR__ . '/vendor/autoload.php';

use App\Phalcon\Configs\MysqlConfig;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

//var_dump(getenv('MYSQL_DATABASE')); exit;

$container = new FactoryDefault();
$mysql = new MysqlConfig();

$container->set(
    'db',
    function () use ($mysql) {
        return new PdoMysql($mysql->getConfig());
    }
);

$app = new Micro($container);