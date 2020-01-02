<?php

return new \Phalcon\Config([
    'application' => [
        'modelsDir'         => __DIR__ . '/../Models/',
        'configsDir'        => __DIR__ . '/../Configs/',
        'controllersDir'    => __DIR__ .'/../Controllers/',
        'viewsDir'          => __DIR__ . '/../Views/',
        'baseUri'           => 'http://localhost/',
    ]
]);