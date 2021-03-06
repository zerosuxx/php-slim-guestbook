<?php

namespace Test\Integration;

use PHPUnit\Framework\TestCase;
use Test\WebTestCase;

class HealthCheckPageTest extends TestCase
{
    use WebTestCase;
    /**
     * @test
     */
    public function callsHealthCheckPage_Returns200OK()
    {
        $response = $this->runApp('GET', '/healthcheck');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getBody().'');
    }
}