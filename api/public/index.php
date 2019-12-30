<?php

use \Phalcon\Mvc\Micro;

$app = new Micro();

$app->get('/', function () {
    $message = array(
        'status' => 200,
        'message' => 'success'
    );
    return json_encode($message);
});

$app->handle(
    $_SERVER["REQUEST_URI"]
);