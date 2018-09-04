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
        $emptyValidator = new \Guestbook\Validator\EmailValidator();
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Wrong email format');
        $emptyValidator->validate('a@');
    }

    /**
     * @test
     */
    public function validate_givenValidEmail_returnsNull() {
        $emptyValidator = new \Guestbook\Validator\EmailValidator();
        $emptyValidator->validate('test@test.test');
        $this->expectNotToPerformAssertions();
    }
}