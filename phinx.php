<?php

require_once 'bootstrap.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'mysql',
            'name' => 'guestbook',
            'user' => 'root',
            'pass' => 'gbroot',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'mysql',
            'name' => 'guestbook_test',
            'user' => 'root',
            'pass' => 'gbroot',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];