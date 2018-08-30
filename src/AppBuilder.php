<?php

namespace Guestbook;

use Slim\App;

/**
 * Class AppBuilder
 */
class AppBuilder
{

    public function build($disableErrorHandler = true): App
    {
        $app = new App();

        if ($disableErrorHandler) {
            unset($app->getContainer()['errorHandler']);
            unset($app->getContainer()['phpErrorHandler']);
        }
        return $app;
    }
}