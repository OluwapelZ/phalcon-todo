<?php

include_once dirname(__FILE__) . '/public/index.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',

        'mysql' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_Host', '127.0.0.1'),
            'database' => getenv('DB_NAME', 'todo_mysql'),
            'username' => getenv('DB_USERNAME', 'root'),
            'password' => getenv('DB_PASSWORD', 'root'),
            'port' => getenv('DB_PORT', '3308'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1:3308',
            'name' => 'todo_mysql',
            'user' => 'root',
            'pass' => 'root',
            'port' => '3308',
            'charset' => 'utf8'
        ],

        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost:3308',
            'name' => 'todo_mysql',
            'Todo' => 'root',
            'pass' => 'root',
            'port' => '3306',
            'charset' => 'utf8'
        ]
    ]
];
