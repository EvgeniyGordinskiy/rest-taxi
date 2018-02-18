<?php

/**
 * Read more on Config Files
 * @link http://phalcon-rest.redound.org/config_files.html
 */

return [

    'debug' => true,
    'hostName' => 'http://phalcon-rest-boilerplate.redound.dev',
    'clientHostName' => 'http://phalcon-rest-app.redound.dev',
    'database' => [

        // Change to your own configuration
        'adapter' => 'Mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'admin',
        'dbname' => 'restTaxi',
    ],
    'redis' => [
        'host' => 'localhost',
        'port' => 6379,
        'persistent' => false,
        'statsKey' => '_dfe_',
        'index' => 1
    ],
    'cors' => [
        'allowedOrigins' => ['*']
    ]
];
