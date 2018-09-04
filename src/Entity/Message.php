<?php

namespace Guestbook\Entity;

/**
 * Class Message
 * @package Guestbook\Entity
 */
class Message
{
    private $name;
    private $email;

    public function __construct(string $name, string $email, string $message)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

}