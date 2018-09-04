<?php

namespace Test\Integration;

use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use Guestbook\Validator\CSRFTokenValidator;
use PHPUnit\Framework\TestCase;
use Test\WebTestCase;

class GuestbookAddPageTest extends TestCase
{
    use WebTestCase;

    private $pdo;

    protected function setUp()
    {
        $this->pdo = (new PDOFactory())->getPDO();
        $this->pdo->query('TRUNCATE TABLE messages');
    }

    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenValidRequestData_ReturnsWithRedirect()
    {
        $csrf = new CSRFTokenValidator();
        $pdo = (new PDOFactory())->getPDO();
        $pdo->query('TRUNCATE TABLE messages');
        $response = $this->runApp('POST', '/guestbook/add', [
            'name' => 'Test name',
            'email' => 'test@test.test',
            'message' => 'Test message',
            '_token' => $csrf->getToken()
        ]);
        $dao = new MessagesDao($this->pdo);
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
    public function callsGuestbookAddPage_GivenInvalidRequestData_ReturnsWithErrors()
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
    public function callsGuestbookAddPage_GivenEmptyRequestData_ReturnsWithErrors()
    {
        $response = $this->runApp('POST', '/guestbook/add', []);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Name can not be empty', (string)$response->getBody());
        $this->assertContains('Email can not be empty', (string)$response->getBody());
        $this->assertContains('Message can not be empty', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenEmptyEmailInRequestData_ReturnsWithErrors()
    {
        $response = $this->runApp('POST', '/guestbook/add', [
            'name' => 'Test name',
            'message' => 'Test message'
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Email can not be empty', (string)$response->getBody());
        $this->assertContains('Test name', (string)$response->getBody());
        $this->assertContains('Test message', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function callsGuestbookAddPage_GivenInvalidDataInRequestData_ReturnsWithErrors()
    {
        $response = $this->runApp('POST', '/guestbook/add', [
            'name' => '<br>',
            'message' => ['Test message'],
            'email' => '()'
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Name can not be empty', (string)$response->getBody());
        $this->assertContains('Email can not be empty', (string)$response->getBody());
        $this->assertContains('Message can not be empty', (string)$response->getBody());
    }
}