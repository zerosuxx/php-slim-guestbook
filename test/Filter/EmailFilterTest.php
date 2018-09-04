<?php

namespace Test\Filter;

use PHPUnit\Framework\TestCase;

/**
 * Class EmailFilterTest
 * @package Test\Filter
 */
class EmailFilterTest extends TestCase
{
    /**
     * @test
     */
    public function filter_GivenValidEmail_ReturnsSameValue() {
        $value = 'test@test.com';
        $filter = new \Guestbook\Filter\EmailFilter();
        $this->assertEquals('test@test.com', $filter->filter($value));
    }
}