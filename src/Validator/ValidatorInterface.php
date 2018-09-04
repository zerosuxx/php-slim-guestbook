<?php

namespace Guestbook\Validator;

/**
 * Interface ValidatorInterface
 * @package Guestbook\Validator
 */
interface ValidatorInterface
{
    /**
     * @throws ValidationException
     * @return void
     */
    public function validate($value);
}