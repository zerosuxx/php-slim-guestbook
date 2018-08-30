<?php

namespace Guestbook;

use Guestbook\Action\GuestbookAction;
use Guestbook\Action\HealthCheckAction;
use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use Guestbook\View\ViewRenderer;
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
        $container[GuestbookAction::class] = function (Container $container) {
            return new GuestbookAction($container->get(MessagesDao::class), $container->get(ViewRenderer::class));
        };
        $container[ViewRenderer::class] = function (Container $container) {
            return new ViewRenderer(__DIR__ . '/../templates/');
        };
        $container[MessagesDao::class] = function (Container $container) {
            return new MessagesDao($container->get('PDO'));
        };
        $container['PDO'] = function () {
            return (new PDOFactory())->getPDO();
        };
    }

    private function addRoutes(App $app) {
        $app->get('/healthcheck', HealthCheckAction::class);
        $app->get('/guestbook', GuestbookAction::class);
    }


}