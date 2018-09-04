<?php

use Guestbook\AppBuilder;

session_start();

require_once dirname(__DIR__) . '/bootstrap.php';

(new AppBuilder())
    ->build()
    ->run();