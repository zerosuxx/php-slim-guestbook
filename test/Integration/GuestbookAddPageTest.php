<?php

namespace Test\Integration;

use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use PHPUnit\Framework\TestCase;
use Test\WebTestCase;

class GuestbookAddPageTest extends TestCase
{
    use WebTestCase;
    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenValidRequestData_ReturnsWithRedirect()
    {
        $pdo = (new PDOFactory())->getPDO();
        $pdo->query('TRUNCATE TABLE messages');
        $response = $this->runApp('POST', '/guestbook/add', [
            'name' => 'Test name',
            'email' => 'test@test.test',
            'message' => 'Test message'
        ]);
        $dao = new MessagesDao($pdo);
        $messages = $dao->getMessages();
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/guestbook', $response->getHeaderLine('Location'));
        $this->assertEquals('Test name', $messages[0]['name']);
        $this->assertEquals('test@test.test', $messages[0]['email']);
        $this->assertEquals('Test message', $messages[0]['message']);
        $this->assertEquals(1, count($messages));
    }

    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenInvalidRequestData_ReturnsWithRedirect()
    {
        $response = $this->runApp('POST', '/guestbook/add', [
            'name' => 'Test name',
            'email' => 'testtest.test',
            'message' => 'Test message'
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Wrong email format', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenEmptyRequestData_ReturnsWithRedirect()
    {
        $response = $this->runApp('POST', '/guestbook/add', []);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Name required', (string)$response->getBody());
        $this->assertContains('Email required', (string)$response->getBody());
        $this->assertContains('Message required', (string)$response->getBody());
    }
}