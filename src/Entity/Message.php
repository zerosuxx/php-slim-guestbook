<?php

namespace Guestbook\Entity;

/**
 * Class Message
 * @package Guestbook\Entity
 */
class Message
{
    private $name;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}