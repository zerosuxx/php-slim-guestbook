<?php

namespace Test\Validator;

use Guestbook\Validator\CSRFTokenValidator;
use Guestbook\Validator\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class CSRFTokenValidatorTest
 * @package Test\Validator
 */
class CSRFTokenValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function validate_GivenValidToken_ReturnsNullAndGenerateNewToken() {
        $_SESSION[CSRFTokenValidator::TOKEN_KEY] = 'valid-token';
        $validator = new \Guestbook\Validator\CSRFTokenValidator();
        $this->assertNull($validator->validate('valid-token'));
        $this->assertNotEquals('valid-token', $validator->getToken());
    }

    /**
     * @test
     */
    public function validate_GivenInValidToken_ThrowsException() {
        $this->expectException(ValidationException::class);
        $_SESSION[CSRFTokenValidator::TOKEN_KEY] = 'valid-token';
        $validator = new \Guestbook\Validator\CSRFTokenValidator();
        $this->assertNull($validator->validate('in-valid-token'));
        $this->assertNotEquals('valid-token', $validator->getToken());
    }
}