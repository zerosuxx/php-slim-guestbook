<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

(new Dotenv(__DIR__ . '/environment/config', '.env.' . getenv('PHP_ENV')))->load();