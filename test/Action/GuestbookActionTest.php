<?php

namespace Test\Action;

use Guestbook\Action\GuestbookAction;
use Guestbook\Dao\MessagesDao;
use Guestbook\Validator\CSRFTokenValidator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class GuestbookActionTest extends TestCase
{
    /**
     * @test
     */
    public function invoke_WithMessagesDaoAndViewRenderer_ReturnsResponseWithRenderedTemplateContents()
    {
        $messages = ['messages' => []];
        $messagesDaoMock = $this->createMock(MessagesDao::class);
        $messagesDaoMock
            ->expects($this->once())
            ->method('getMessages')
            ->willReturn($messages);

        $responseMock = $this->createMock(Response::class);

        $viewRendererMock = $this->createMock(Twig::class);

        $viewRendererMock
            ->expects($this->once())
            ->method('render')
            ->with($responseMock, 'guestbook.html.twig', ['messages' => $messages, 'token' => null])
            ->willReturn($responseMock);

        $action = new GuestbookAction($messagesDaoMock, $viewRendererMock, $this->createMock(CSRFTokenValidator::class));

        $result = $action($this->createMock(Request::class), $responseMock, []);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

}