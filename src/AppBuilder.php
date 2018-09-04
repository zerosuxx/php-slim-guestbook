<?php

namespace Guestbook;

use Guestbook\Action\GuestbookAction;
use Guestbook\Action\GuestbookAddAction;
use Guestbook\Action\HealthCheckAction;
use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use Guestbook\Form\Form;
use Guestbook\Form\MessageForm;
use Guestbook\Validator\ValidatorChain;
use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class AppBuilder
{

    public function build(): App
    {
        $container = new Container($this->getConfig());
        $app = new App($container);

        $this->setupTwig($container);
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
            return new GuestbookAction($container->get(MessagesDao::class), $container->get('view'));
        };
        $container[GuestbookAddAction::class] = function (Container $container) {
            return new GuestbookAddAction($container->get(MessagesDao::class), $container->get('view'), new MessageForm());
        };
        $container[MessagesDao::class] = function (Container $container) {
            return new MessagesDao($container->get('PDO'));
        };
        $container['PDO'] = function () {
            return (new PDOFactory())->getPDO();
        };
    }

    private function setupTwig(Container $container) {
        $container['view'] = function ($container) {
            $view = new Twig(__DIR__ . "/../templates/", [
                'cache' => false
            ]);

            $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
            $view->addExtension(new TwigExtension($container->get('router'), $basePath));

            return $view;
        };
    }

    private function addRoutes(App $app) {
        $app->get('/healthcheck', HealthCheckAction::class);
        $app->get('/guestbook', GuestbookAction::class);
        $app->post('/guestbook/add', GuestbookAddAction::class);
    }


}