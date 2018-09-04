<?php

namespace Guestbook\Form;

use Guestbook\Entity\Message;
use Guestbook\Filter\EmailFilter;
use Guestbook\Filter\StringFilter;
use Guestbook\Validator\CSRFTokenValidator;
use Guestbook\Validator\EmailValidator;
use Guestbook\Validator\EmptyValidator;
use Guestbook\Validator\ValidatorChain;

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