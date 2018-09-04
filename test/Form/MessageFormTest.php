<?php

namespace Test\Form;

use Guestbook\Entity\Message;
use Guestbook\Form\MessageForm;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zero\Form\Validator\CSRFTokenValidator;

/**
 * Class FormTest
 * @package Test\Form
 */
class MessageFormTest extends TestCase
{
    /**
     * @var CSRFTokenValidator
     */
    private $csrf;

    /**
     * @var MessageForm
     */
    private $form;
    
    protected function setUp()
    {
        $this->csrf = new CSRFTokenValidator();
        $this->form = new MessageForm($this->csrf);
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
                '_token' => $this->csrf->getToken()
            ]);

        $message = $this->form
            ->handle($mockRequest)
            ->getMessage();
        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals('Test name', $message->getName());
        $this->assertEquals('test@test.test', $message->getEmail());
    }
}