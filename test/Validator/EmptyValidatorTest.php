<?php

namespace Test\Validator;

use Guestbook\Validator\EmptyValidator;
use Guestbook\Validator\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class EmptyValidatorTets
 * @package Test\Validator
 */
class EmptyValidatorTest extends TestCase {

    /**
     * @test
     */
    public function validate_givenEmptyString_throwsExceptionWithErrorMessage() {
        $emptyValidator = new EmptyValidator('Name', '');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name can not be empty');
        $emptyValidator->validate();
    }

    /**
     * @test
     */
    public function validate_givenNotEmptyString_ReturnsNull() {
        $emptyValidator = new EmptyValidator('Name', 'Test name');
        $emptyValidator->validate();
        $this->expectNotToPerformAssertions();
    }
}