<?php


namespace App\Phalcon\Configs;

class MysqlConfig
{
    public static function getConfig()
    {
        return array(
            'host'     => getenv('MYSQL_HOST', true),
            'username' => getenv('MYSQL_USER', true),
            'password' => getenv('MYSQL_PASSWORD', true),
            'dbname'   => getenv('MYSQL_DATABASE', true),
        );
    }
}