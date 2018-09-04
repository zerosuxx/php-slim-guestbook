<?php

namespace Guestbook\Form;

use Guestbook\Entity\Message;
use Zero\Form\Filter\EmailFilter;
use Zero\Form\Filter\StringFilter;
use Zero\Form\Form;
use Zero\Form\Validator\CSRFTokenValidator;
use Zero\Form\Validator\EmailValidator;
use Zero\Form\Validator\EmptyValidator;
use Zero\Form\Validator\ValidatorChain;

/**
 * Class MessageForm
 * @package Guestbook\Form
 */
class MessageForm extends Form
{

    public function __construct(CSRFTokenValidator $csrf)
    {
        $emailValidator = new ValidatorChain();
        $emailValidator
            ->add(new EmptyValidator('Email'))
            ->add(new EmailValidator());

        $this
            ->input('name', new StringFilter(), new EmptyValidator('Name'))
            ->input('email', new EmailFilter(), $emailValidator)
            ->input('message', new StringFilter(), new EmptyValidator('Message'))
            ->input('_token', new StringFilter(), $csrf);
    }

    public function getMessage()
    {
        $data = $this->getData();
        return new Message((string)$data['name'], (string)$data['email'], (string)$data['message']);
    }
}