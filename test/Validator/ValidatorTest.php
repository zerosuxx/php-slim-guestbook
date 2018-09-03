<?php

namespace Test\Validator;

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
    public function validate_givenOneValidatorAndItThrowsException_throwsExceptionInArray() {
        $validator = new \Guestbook\Validator\Validator();
        $emptyValidator = new EmptyValidator('Name', '');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name can not be empty');
        $validator->add($emptyValidator)->validate();

    }
}