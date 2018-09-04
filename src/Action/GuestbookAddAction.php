<?php

namespace Guestbook\Action;

use Guestbook\Dao\MessagesDao;
use Guestbook\Filter\EmailFilter;
use Guestbook\Filter\StringFilter;
use Guestbook\Form\Form;
use Guestbook\Validator\EmailValidator;
use Guestbook\Validator\EmptyValidator;
use Guestbook\Validator\ValidatorChain;
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
     * @var Form
     */
    private $form;


    public function __construct(MessagesDao $messagesDao, Twig $view, Form $form)
    {
        $this->messagesDao = $messagesDao;
        $this->view = $view;
        $this->form = $form;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $emailValidator = new ValidatorChain();
        $emailValidator
            ->add(new EmptyValidator('Email'))
            ->add(new EmailValidator());

        $this->form
            ->input('name', new StringFilter(), new EmptyValidator('Name'))
            ->input('email', new EmailFilter(), $emailValidator)
            ->input('message', new StringFilter(), new EmptyValidator('Message'))
            ->handle($request);

        if($this->form->validate()) {
            $data = $this->form->getData();
            $this->messagesDao->saveMessage($data['name'], $data['email'], $data['message'], new \DateTime());
            return $response->withRedirect('/guestbook');
        } else {
            return $this->view->render($response, 'guestbook.html.twig', [
                'errors' => $this->form->getErrors(),
                'messages' => $this->messagesDao->getMessages(),
                //'data' => $this->form->getData()
            ]);
        }
    }
}