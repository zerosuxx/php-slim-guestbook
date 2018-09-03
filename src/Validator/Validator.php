<?php

namespace Guestbook\Validator;

/**
 * Class Validator
 * @package Guestbook\Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function add(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function validate()
    {
        $this->validator->validate();
    }
}