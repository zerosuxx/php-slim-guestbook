<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
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

//        $mv = (new MessageValidator())
//            ->add(new EmptyValidator($name))
//            ->add(new EmptyValidator($email))
//            ->add(new EmailValidator($email))
//            ->add(new EmptyValidator($message))
//            ->validate();

        $errors = [];
        if (strlen($name) === 0) {
            $errors['name'] = 'Name required';
        }

        if (strlen($email) === 0) {
            $errors['email'] = 'Email required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Wrong email format';
        }

        if (strlen($message) === 0) {
            $errors['message'] = 'Message required';
        }

        if (empty($errors)) {
            $this->messagesDao->saveMessage($name, $email, $message, new \DateTime());
            return $response->withRedirect('/guestbook');
        } else {
            return $this->view->render($response, 'guestbook.html.twig', ['errors' => $errors]);
        }

    }
}