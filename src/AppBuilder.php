<?php

namespace Guestbook;

use Guestbook\Action\HealthCheckAction;
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
        $this->addRoutes($app);
        return $app;
    }

    private function addRoutes(App $app) {
        $app->get('/healthcheck', HealthCheckAction::class);
    }
}