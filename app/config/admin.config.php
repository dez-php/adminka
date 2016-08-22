<?php

return [
    'application' => [
        'staticPath' => '/web/',
        'sharedPath' => '/shared/',
        'basePath' => '/',
        'autoload' => [
            'Adminka\\Controllers' => __DIR__ . '/../controllers',
            'Adminka\\Models' => __DIR__ . '/../models',
            'Adminka\\Services' => __DIR__ . '/../services',
            'Adminka\\Core' => __DIR__ . '/../core',
        ],
        'controllerNamespace' => 'Adminka\\Controllers\\',
        'viewDirectory' => __DIR__ . '/../templates',
        'debug' => [
            'exceptions' => 1,
            'php_errors' => 1,
        ],
        'dev-config' => __DIR__ . '/dev.config.php',
    ],
    'db' => [
        'connection_name' => 'development',
        'connection' => [
            'development' => [
                'dsn' => 'mysql:host=localhost;dbname=my-test',
                'user' => 'root',
                'password' => '',
            ],
        ],
    ],
    'server' => [
        'timezone' => 'Europe/Kiev',
        'displayErrors' => 'Off',
        'errorLevel' => 0,
    ],
];