<?php
require_once 'bootstrap.php';

$dsn = 'mysql:host=mysql;charset=utf8mb4';
$pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));
$pdo->query("CREATE DATABASE IF NOT EXISTS guestbook");
$pdo->query("CREATE DATABASE IF NOT EXISTS guestbook_test");

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
            'user' => 'guestbook',
            'pass' => 'guestbook',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'mysql',
            'name' => 'guestbook_test',
            'user' => 'guestbook',
            'pass' => 'guestbook',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];