<?php

namespace Guestbook\Filter;

/**
 * Class StringFilter
 * @package Guestbook\Filter
 */
class StringFilter
{
    public function filter($value) {
        return trim(filter_var($value, FILTER_SANITIZE_STRING));
    }
}