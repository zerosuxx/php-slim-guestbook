<?php

namespace Test\Action;

use Guestbook\Action\HealthCheckAction;
use Guestbook\Dao\PDOFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheckActionTest extends TestCase
{
    /**
     * @test
     */
    public function invoke_WithSuccessfullyConnectedDatabase_ReturnsResponse() {
        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock
            ->expects($this->once())
            ->method('query')
            ->with('SELECT 1');

        $pdoFactoryMock = $this->createMock(PDOFactory::class);
        $pdoFactoryMock
            ->expects($this->once())
            ->method('getPDO')
            ->willReturn($pdoMock);

        $responseMock = $this->createMock(Response::class);

        $responseMock
            ->expects($this->once())
            ->method('write')
            ->with('OK');

        $responseMock
            ->expects($this->never())
            ->method('withStatus');

        $healthCheckAction = new HealthCheckAction($pdoFactoryMock);

        $result = $healthCheckAction($this->createMock(Request::class), $responseMock, []);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    /**
     * @test
     */
    public function invoke_WithErrorInConnection_ReturnsResponse() {

        $pdoFactoryMock = $this->createMock(PDOFactory::class);
        $pdoFactoryMock
            ->expects($this->once())
            ->method('getPDO')
            ->willThrowException(new \PDOException());

        $responseMock = $this->createMock(Response::class);

        $responseMock
            ->expects($this->once())
            ->method('withStatus')
            ->with(500)
            ->willReturn($responseMock);

        $healthCheckAction = new HealthCheckAction($pdoFactoryMock);

        $result = $healthCheckAction($this->createMock(Request::class), $responseMock, []);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
}