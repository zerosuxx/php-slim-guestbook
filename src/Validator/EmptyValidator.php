<?php

namespace Guestbook\Validator;

/**
 * Class EmptyValidator
 * @package Guestbook\Validator
 */
class EmptyValidator implements ValidatorInterface
{
    private $name;
    private $value;

    /**
     * EmptyValidator constructor.
     * @param $name
     * @param mixed $value
     */
    public function __construct($name, $value)
    {
        $this->value = $value;
        $this->name = $name;
    }

    public function validate()
    {
        if(strlen($this->value) === 0) {
            throw new ValidationException(sprintf('%s can not be empty', $this->name));
        }
    }
}