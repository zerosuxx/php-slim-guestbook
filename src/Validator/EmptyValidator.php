<?php

namespace Guestbook\Validator;

/**
 * Class EmptyValidator
 * @package Guestbook\Validator
 */
class EmptyValidator implements ValidatorInterface
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function validate($value)
    {
        if(strlen($value) === 0) {
            throw new ValidationException(sprintf('%s can not be empty', $this->name));
        }
    }
}