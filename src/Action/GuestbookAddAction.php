<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
use Guestbook\View\ViewRenderer;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * Class GuestbookAddAction
 * @package Guestbook\Action
 */
class GuestbookAddAction
{
    /**
     * @var MessagesDao
     */
    private $messagesDao;
    /**
     * @var Twig
     */
    private $view;


    public function __construct(MessagesDao $messagesDao, Twig $view)
    {
        $this->messagesDao = $messagesDao;
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $name = $request->getParsedBodyParam('name');
        $email = $request->getParsedBodyParam('email');
        $message = $request->getParsedBodyParam('message');

        if (strlen($name) === 0) {
            return $this->view->render($response, 'guestbook.html.twig', ['errors' => 'Name required,Email required,Message required']);
        }
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->messagesDao->saveMessage($name, $email, $message, new \DateTime());
            return $response->withRedirect('/guestbook');
        } else {
            return $this->view->render($response, 'guestbook.html.twig', ['errors' => 'Wrong email format']);
        }

    }
}