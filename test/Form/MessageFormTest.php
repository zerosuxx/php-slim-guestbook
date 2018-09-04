<?php

namespace Test\Form;

use Guestbook\Entity\Message;
use Guestbook\Form\MessageForm;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class FormTest
 * @package Test\Form
 */
class MessageFormTest extends TestCase
{

    /**
     * @var MessageForm
     */
    private $form;
    
    protected function setUp()
    {
        $this->form = new MessageForm();
    }

    /**
     * @test
     */
    public function getMessage_GivenSomeInputAndRequest_ReturnsMessageInstance()
    {
        $mockRequest = $this->createMock(ServerRequestInterface::class);
        $mockRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'name' => 'Test name<br>',
                'email' => 'test@test.test()',
                'message' => 'Test message<br>',
            ]);

        $message = $this->form
            ->handle($mockRequest)
            ->getMessage();
        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('Test name', $message->getName());
        $this->assertEquals('test@test.test', $message->getEmail());
        $this->assertEquals('Test message', $message->getMessage());
    }
}