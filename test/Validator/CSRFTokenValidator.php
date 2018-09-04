<?php

namespace Test\Validator;

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
        $_SESSION['_csrf_token'] = 'valid-token';
        $validator = new \Guestbook\Validator\CSRFTokenValidator();
        $this->assertNull($validator->validate('valid-token'));
        $this->assertNotEquals('valid-token', $validator->getToken());
    }
}