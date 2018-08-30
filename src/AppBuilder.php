<?php

namespace Guestbook;

use Guestbook\Action\HealthCheckAction;
use Guestbook\Dao\PDOFactory;
use Slim\App;
use Slim\Container;

class AppBuilder
{

    public function build(): App
    {
        $container = new Container($this->getConfig());
        $app = new App($container);

        $this->addDependencies($container);
        $this->addRoutes($app);

        return $app;
    }

    private function getConfig() {
        return [
            'settings' => [
                'displayErrorDetails' => true,
            ],
        ];
    }

    private function addDependencies(Container $container) {
        $container[HealthCheckAction::class] = function (Container $container) {
            return new HealthCheckAction(new PDOFactory());
        };
        $container['pdo'] = function () {
            return (new PDOFactory())->getPDO();
        };
    }

    private function addRoutes(App $app) {
        $app->get('/healthcheck', HealthCheckAction::class);
    }


}