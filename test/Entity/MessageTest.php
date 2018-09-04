<?php

namespace Test\Entity;

use Guestbook\Entity\Message;
use PHPUnit\Framework\TestCase;

/**
 * Class Message
 * @package Test\Entity
 */
class MessageTest extends TestCase
{
    /**
     * @test
     */
    public function getName_ReturnsName()
    {
        $message = new Message('Test name', '', '');
        $this->assertEquals('Test name', $message->getName());
    }

    /**
     * @test
     */
    public function getEmail_ReturnsEmail()
    {
        $message = new Message('', 'test@test.test', '');
        $this->assertEquals('test@test.test', $message->getEmail());
    }

    /**
     * @test
     */
    public function getMessage_ReturnsMessage()
    {
        $message = new Message('', '', 'test message');
        $this->assertEquals('test message', $message->getMessage());
    }
}