<?php

error_reporting(E_ALL);

require __DIR__ . '/../bootstrap.php';

use Phalcon\Http\Response;

/**
 * Method GET: 
 * Endpoint: /api/robots
 * @request curl -i -X GET http://localhost/api/robots
 */
$app->get(
    '/api/robots', 
    function () use ($app) 
    {
        $phql = 'SELECT id, name, type FROM App\Phalcon\Models\Robots ORDER BY name';

        try {
            $robots = $app->modelsManager->executeQuery($phql);
            
            $data = array();

            foreach ($robots as $robot) {
                $data[] = [
                    'id' => $robot->id,
                    'name' => $robot->name,
                    'type' => $robot->type,
                ];
            }
            
            $response = new Response();
            
            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'robots' => $data,
                ],
                JSON_PRETTY_PRINT
            );

            return $response;
        } catch(Phalcon\Db\Exception $e) {
            print($e->getTrace());
        }
    }
);

/**
 * Method GET
 * Endpoint: /api/robots/search/{name}
 * @request curl -i -X GET http://localhost/api/robots/search/PO
 */
$app->get(
    '/api/robots/search/{name}', 
    function ($name) use ($app) 
    {
        $phql = "SELECT * FROM App\Phalcon\Models\Robots WHERE name LIKE :name: ORDER BY name";

        $robots = $app->modelsManager->executeQuery($phql, ['name' => "%" . $name . "%"]);

        $data = array();

        foreach ($robots as $robot) {
            $data[] = [
                'id' => $robot->id,
                'name' => $robot->name,
            ];
        }

        $response = new Response();
            
        $response->setStatusCode(200, 'success');
        $response->setJsonContent(
            [
                'status' => 200,
                'search' => $name,
                'robots' => $data,
            ],
            JSON_PRETTY_PRINT
        );

        return $response;
    }
);

/**
 * Method GET
 * Endpoint: /api/robots/1
 * @request curl -i -X GET http://localhost/api/robots/1
 */
$app->get(
    '/api/robots/{id:[0-9]+}', 
    function ($id) use($app) 
    {
        $phql = "SELECT * FROM App\Phalcon\Models\Robots WHERE id = :id:";

        $robot = $app->modelsManager->executeQuery(
            $phql, [ 'id' => $id ]
        )->getFirst();

        $response = new Response();
        if ($robot === false || $robot->id === null || $robot->name === null) {
            return $response->setJsonContent(
                [
                    'status' => 204,
                    'message' => 'No Content',
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        } 
        
        $response->setJsonContent(
            [
                'status' => 200,
                'data' => [
                    'id' => $robot->id,
                    'name' => $robot->name,
                    'type' => $robot->type,
                    'year' => $robot->year,
                ]
            ],
            JSON_PRETTY_PRINT
        );
        
        return $response;
    }
);

/**
 * Method POST: /api/robots
 * @request curl -i -X POST \ 
 *          -H 'Content-Type: application/json' \
 *          -d '{"name":"C-3PO","type":"droid","year":1977}' \
 *          http://localhost/api/robots
 */
$app->post(
    '/api/robots', 
    function () use($app) 
    {
        $robot = $app->request->getJsonRawBody();

        $phql = "INSERT INTO App\Phalcon\Models\Robots (name, type, year) VALUES (:name:, :type:, :year:)";

        $status = $app->modelsManager->executeQuery(
            $phql, 
            [
                'name' => $robot->name,
                'type' => $robot->type,
                'year' => $robot->year,
            ]
        );

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(201, 'Created');
            $robot->id = $status->getModel()->id;
            $response->setJsonContent(
                [
                    'status' => 201,
                    'data' => $robot,
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');
        
        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }
        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );
        return $response;
    }
);

/**
 * Method PUT
 * Endpoint: /api/robots/{id:}
 * @request curl -i -X PUT \
 *          -H 'Content-Type: application/json' \
 *          -d '{"name":"CryBot-1","type":"virtual","year":2020}' \
 *          http://localhost/api/robots/3
 */
$app->put(
    '/api/robots/{id:[0-9]+}', 
    function ($id) use ($app) 
    {
        $robot = $app->request->getJsonRawBody();

        $phql = "UPDATE App\Phalcon\Models\Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

        $status = $app->modelsManager->executeQuery(
            $phql,
            [
                'id'    => $id,
                'name'  => $robot->name,
                'type'  => $robot->type,
                'year'  => $robot->year,
            ]
        );

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'message' => "robot with ID {$id} updated",
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');
        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }
        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );
        return $response;
    }
);

/**
 * Method DELETE
 * Endpoint: /api/robots/{id:}
 * @request curl -i -X DELETE http://localhost/api/robots/8
 */
$app->delete(
    '/api/robots/{id:[0-9]+}', 
    function ($id) use ($app) {
        $phql = "DELETE FROM App\Phalcon\Models\Robots WHERE id = :id:";
        
        $status = $app->modelsManager->executeQuery($phql, [ 'id' => $id ]);

        $response = new Response();

        if ($status->success() === true) {
            $response->setStatusCode(200, 'success');
            $response->setJsonContent(
                [
                    'status' => 200,
                    'message' => "robot with ID {$id} deleted",
                ],
                JSON_PRETTY_PRINT
            );
            return $response;
        }

        $response->setStatusCode(409, 'Conflict');
        
        $errors = [];
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }
        
        $response->setJsonContent(
            [
                'status' => 409,
                'error' => $errors,
            ],
            JSON_PRETTY_PRINT
        );

        return $response;
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);