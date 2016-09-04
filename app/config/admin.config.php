<?php

return [
    'application' => [
        'static_path' => '/web/',
        'shared_path' => '/shared/',
        'base_path' => '/',
        'autoload' => [
            'Adminka\\Controllers' => __DIR__ . '/../controllers',
            'Adminka\\Models' => __DIR__ . '/../models',
            'Adminka\\Services' => __DIR__ . '/../services',
            'Adminka\\Core' => __DIR__ . '/../core',
        ],
        'controller' => [
            'root_directory' => '/var/www/site/app/controllers',
            'namespace' => 'Adminka\\Controllers',
        ],
        'model' => [
            'root_directory' => '/var/www/site/app/models'
        ],
        'view' => [
            'root_directory' => __DIR__ . '/../templates',
        ],
        'module' => [
            'roo_directory' => __DIR__ . '/../modules'
        ],
        'debug' => [
            'exceptions' => 1,
            'php_errors' => 1,
        ],
        'dev-config' => __DIR__ . '/dev.config.php',
    ],
    'db' => [
        'connection_name' => 'production',
        'connection' => [
            'production' => [
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