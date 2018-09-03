<?php

namespace Guestbook\Validator;

/**
 * Class Validator
 * @package Guestbook\Validator
 */
class Validator implements ValidatorInterface
{
    /**
     * @var ValidatorInterface[]
     */
    private $validators;

    public function add(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    public function validate()
    {
        $errors = [];
        foreach ($this->validators as $validator) {
            try {
                $validator->validate();
            } catch (ValidationException $ex) {
                $errors[] = $ex->getMessage();
            }
        }
        if (!empty($errors)) {
            throw new ValidationException(implode("\n", $errors));
        }
    }
}