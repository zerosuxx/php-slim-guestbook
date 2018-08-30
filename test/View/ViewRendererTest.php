<?php

namespace Test\View;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ViewRendererTest extends TestCase
{
    /**
     * @test
     */
    public function render_ReturnsTemplateFileContents() {
        $renderer = new \Guestbook\View\ViewRenderer(__DIR__ . '/TestAsset/');
        $responseMock = $this->createMock(ResponseInterface::class);

        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock
            ->expects($this->once())
            ->method('write')
            ->with('Hello Joe!');

        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($streamMock);

        $result = $renderer->render($responseMock, 'test_template.php', ['name' => 'Joe']);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
}