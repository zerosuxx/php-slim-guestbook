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
        $message = new \Guestbook\Entity\Message('Test name', null, null);
        $this->assertEquals('Test name', $message->getName());
    }
}