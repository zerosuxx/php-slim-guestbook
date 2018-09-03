<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
use Guestbook\Validator\EmailValidator;
use Guestbook\Validator\EmptyValidator;
use Guestbook\Validator\ValidationException;
use Guestbook\Validator\Validator;
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
    /**
     * @var Validator
     */
    private $validator;


    public function __construct(MessagesDao $messagesDao, Twig $view, Validator $validator)
    {
        $this->messagesDao = $messagesDao;
        $this->view = $view;
        $this->validator = $validator;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $name = $request->getParsedBodyParam('name');
        $email = $request->getParsedBodyParam('email');
        $message = $request->getParsedBodyParam('message');

        try {
            $this->validator
                ->add(new EmptyValidator('Name', $name))
                ->add(new EmptyValidator('Email', $email))
                ->add(new EmailValidator($email))
                ->add(new EmptyValidator('Message', $message))
                ->validate();
            $this->messagesDao->saveMessage($name, $email, $message, new \DateTime());
            return $response->withRedirect('/guestbook');
        } catch (ValidationException $ex) {
            return $this->view->render($response, 'guestbook.html.twig', ['errors' => $ex->getMessage()]);
        }
    }
}