<?php

namespace Test\Action;

use Guestbook\Action\GuestbookAction;
use Guestbook\Dao\MessagesDao;
use Guestbook\View\ViewRenderer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

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

        $viewRendererMock = $this->createMock(ViewRenderer::class);

        $viewRendererMock
            ->expects($this->once())
            ->method('render')
            ->with($responseMock, 'guestbook.php', ['messages' => $messages])
            ->willReturn($responseMock);

        $action = new GuestbookAction($messagesDaoMock, $viewRendererMock);

        $result = $action($this->createMock(Request::class), $responseMock, []);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

}