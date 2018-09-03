<?php

namespace Test\Validator;

use Guestbook\Validator\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class EmptyValidatorTest
 * @package Test\Validator
 */
class EmailValidatorTest extends TestCase {

    /**
     * @test
     */
    public function validate_givenInvalidEmail_throwsExceptionWithErrorMessage() {
        $emptyValidator = new \Guestbook\Validator\EmailValidator('a@');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Wrong email format');
        $emptyValidator->validate();
    }

    /**
     * @test
     */
    public function validate_givenValidEmail_returnsNull() {
        $emptyValidator = new \Guestbook\Validator\EmailValidator('test@test.test');
        $emptyValidator->validate();
        $this->expectNotToPerformAssertions();
    }
}