<?php

use Guestbook\AppBuilder;

require_once dirname(__DIR__) . '/bootstrap.php';

(new AppBuilder())->build()->run();