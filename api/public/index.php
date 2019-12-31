<?php

error_reporting(E_ALL);

require __DIR__ . '/../bootstrap.php';

$app->get('/api/robots', function () use ($app) {
    $phql = 'SELECT id, name FROM App\Phalcon\Models\Robots ORDER BY name';

    try {
        $robots = $app->modelsManager->executeQuery($phql);
        
        $data = array();

        foreach ($robots as $robot) {
            $data[] = [
                'id' => $robot->id,
                'name' => $robot->name,
            ];
        }
        
        $message = [
            'status' => 200,
            'robots' => $data,
        ];

        return json_encode($message);
    } catch(Phalcon\Db\Exception $e) {
        print($e->getTrace());
    }
});

$app->get('/api/robots/search/{name}', function ($name) use ($app) {
    $phql = "SELECT * FROM App\Phalcon\Models\Robots WHERE name LIKE :name: ORDER BY name";

    $robots = $app->modelsManager->executeQuery($phql, ['name' => '%' . $name . '%']);

    $data = array();

    foreach ($robots as $robot) {
        $data[] = [
            'id' => $robot->id,
            'name' => $robot->name,
        ];
    }

    $message = [
        'status' => 200,
        'search' => $name,
        'robots' => $data,
    ];

    return json_encode($message);
});

$app->get('/api/robots/{id:[0-9]+}', function ($id) {
    return json_encode("GET {$id} Robots");
});

$app->post('/api/robots', function () {
    return json_encode("POST new Robot");
});

$app->put('/api/robots/{id:[0-9]+}', function ($id) {
    return json_encode("PUT Robot");
});

$app->delete('/api/robots/{id:[0-9]+}', function ($id) {
    return json_encode("DELETE Robot");
});

$app->handle(
    $_SERVER["REQUEST_URI"]
);