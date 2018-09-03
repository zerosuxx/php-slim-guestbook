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


    public function __construct(MessagesDao $messagesDao)
    {
        $this->messagesDao = $messagesDao;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $name = $request->getParsedBodyParam('name');
        $email = $request->getParsedBodyParam('email');
        $message = $request->getParsedBodyParam('message');
        $this->messagesDao->saveMessage($name, $email, $message, new \DateTime());
        return $response->withRedirect('/guestbook');
    }
}