<?php

namespace Test\Filter;

use PHPUnit\Framework\TestCase;

/**
 * Class StringFilterTest
 * @package Test\Filter
 */
class StringFilterTest extends TestCase
{
    /**
     * @test
     */
    public function filter_GivenValidData_ReturnsSameValue() {
        $value = 'Test string';
        $filter = new \Guestbook\Filter\StringFilter();
        $this->assertEquals('Test string', $filter->filter($value));
    }
}