<?php

namespace Guestbook\Validator;

/**
 * Class EmailValidator
 * @package Guestbook\Validator
 */
class EmailValidator implements ValidatorInterface
{
    /**
     * @var string
     */
    private $value;

    /**
     * EmailValidator constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function validate()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Wrong email format');
        }
    }
}