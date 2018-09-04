<?php

namespace Guestbook\Filter;

/**
 * Class EmailFilter
 * @package Guestbook\Filter
 */
class EmailFilter
{
    public function filter($value)
    {
        return filter_var($value, FILTER_SANITIZE_EMAIL);
    }
}