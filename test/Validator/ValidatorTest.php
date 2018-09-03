<?php

namespace Test\Validator;

use Guestbook\Validator\EmailValidator;
use Guestbook\Validator\EmptyValidator;
use Guestbook\Validator\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 * @package Test\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function validate_givenOneValidatorAndItThrowsException_throwsException() {
        $validator = new \Guestbook\Validator\Validator();
        $emptyValidator = new EmptyValidator('Name', '');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name can not be empty');
        $validator
            ->add($emptyValidator)
            ->validate();

    }

    /**
     * @test
     */
    public function validate_givenMultipleValidatorAndItThrowsException_throwsException() {
        $validator = new \Guestbook\Validator\Validator();
        $emptyValidator = new EmptyValidator('Name', '');
        $emailValidator = new EmailValidator('');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name can not be empty' . "\n" . 'Wrong email format');
        $validator
            ->add($emptyValidator)
            ->add($emailValidator)
            ->validate();

    }
}