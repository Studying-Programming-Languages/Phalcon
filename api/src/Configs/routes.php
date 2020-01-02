<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

$router->removeExtraSlashes(true);

// Router for pages not found
$router->setDefaults([
    'namespace'     => 'App\Phalcon\Controllers',
    'controller'    => 'error',
    'action'        => 'page404',
]);

// Routers for API
$api = new RouterGroup([
    'namespace' => 'App\Phalcon\Controllers'    
]);

/**
 * Method GET: 
 * Endpoint: /api/robots
 * @request curl -i -X GET http://localhost/api/robots
 */
$api->addGet(
    '/api/robots',
    [
        'controller'    => 'robots',
        'action'        => 'getRobots',
    ]  
);

/**
 * Method GET
 * Endpoint: /api/robots/search/{name}
 * @request curl -i -X GET http://localhost/api/robots/search/PO
 */
$api->addGet(
    '/api/robots/search/{name}',
    [
        'controller'    => 'robots',
        'action'        => 'searchRobots'
    ]
);

/**
 * Method GET
 * Endpoint: /api/robots/1
 * @request curl -i -X GET http://localhost/api/robots/1
 */
$api->addGet(
    '/api/robots/{id:[0-9]+}',
    [
        'controller'    => 'robots',
        'action'        => 'getById'
    ]
);

/**
 * Method POST: /api/robots
 * @request curl -i -X POST \ 
 *          -H 'Content-Type: application/json' \
 *          -d '{"name":"C-3PO","type":"droid","year":1977}' \
 *          http://localhost/api/robots
 */
$api->addPost(
    '/api/robots',
    [
        'controller' => 'robots',
        'action'     => 'createRobot',
    ]
);

/**
 * Method PUT
 * Endpoint: /api/robots/{id:}
 * @request curl -i -X PUT \
 *          -H 'Content-Type: application/json' \
 *          -d '{"name":"CryBot-1","type":"virtual","year":2020}' \
 *          http://localhost/api/robots/3
 */
$api->addPut(
    '/api/robots/{id:[0-9]+}',
    [
        'controller' => 'robots',
        'action'     => 'updateRobot',
    ]
);

/**
 * Method DELETE
 * Endpoint: /api/robots/{id:}
 * @request curl -i -X DELETE http://localhost/api/robots/8
 */
$api->addDelete(
    '/api/robots/{id:[0-9]+}',
    [
        'controller' => 'robots',
        'action'     => 'deleteRobot'
    ]
);

$router->mount($api);

return $router;
