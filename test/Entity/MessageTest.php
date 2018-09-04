<?php

namespace Test\Entity;

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
        $message = new \Guestbook\Entity\Message('Test name', '', '');
        $this->assertEquals('Test name', $message->getName());
    }
    /**
     * @test
     */
    public function getEmail_ReturnsName()
    {
        $message = new \Guestbook\Entity\Message('', 'test@test.test', '');
        $this->assertEquals('test@test.test', $message->getEmail());
    }
}