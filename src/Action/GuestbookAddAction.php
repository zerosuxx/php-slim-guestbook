<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
use Guestbook\Form\Form;
use Guestbook\Form\MessageForm;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Zero\Form\Validator\CSRFTokenValidator;

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

    /**
     * @var Form
     */
    private $form;
    /**
     * @var CSRFTokenValidator
     */
    private $csrf;


    public function __construct(MessagesDao $messagesDao, Twig $view, MessageForm $form, CSRFTokenValidator $csrf)
    {
        $this->messagesDao = $messagesDao;
        $this->view = $view;
        $this->form = $form;
        $this->csrf = $csrf;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        if($this->form->handle($request)->isValid()) {
            $message = $this->form->getMessage();
            $this->messagesDao->saveMessage($message);
            return $response->withRedirect('/guestbook');
        } else {
            return $this->view->render($response, 'guestbook.html.twig', [
                'messages' => $this->messagesDao->getMessages(),
                'errors' => $this->form->getErrors(),
                'data' => $this->form->getData(),
                'token' => $this->csrf->getToken()
            ]);
        }
    }
}