<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

(new Dotenv(__DIR__ , '.env.' . getenv('PHP_ENV')))->load();