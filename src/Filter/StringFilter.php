<?php

namespace Guestbook\Filter;

/**
 * Class StringFilter
 * @package Guestbook\Filter
 */
class StringFilter
{

    /**
     * StringFilter constructor.
     */
    public function __construct()
    {
    }

    public function filter($value) {
        return $value;
    }
}