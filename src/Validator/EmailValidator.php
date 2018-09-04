<?php

namespace Guestbook\Validator;

/**
 * Class EmailValidator
 * @package Guestbook\Validator
 */
class EmailValidator implements ValidatorInterface
{
    public function validate($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Wrong email format');
        }
    }
}