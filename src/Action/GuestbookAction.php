<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
use Guestbook\View\ViewRenderer;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * Class GuestbookAction
 * @package Guestbook\Action
 */
class GuestbookAction
{
    /**
     * @var MessagesDao
     */
    private $messagesDao;

    /**
     * @var ViewRenderer
     */
    private $renderer;

    public function __construct(MessagesDao $messagesDao, Twig $renderer)
    {
        $this->messagesDao = $messagesDao;
        $this->renderer = $renderer;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $messages = $this->messagesDao->getMessages();
        return $this->renderer->render($response, 'guestbook.html.twig', ['messages' => $messages]);
    }
}