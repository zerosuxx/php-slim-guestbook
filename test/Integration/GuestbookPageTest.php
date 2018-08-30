<?php

namespace Test\Integration;

use Guestbook\Dao\PDOFactory;
use PHPUnit\Framework\TestCase;
use Test\WebTestCase;

class GuestbookPageTest extends TestCase
{
    use WebTestCase;
    /**
     * @test
     */
    public function callsGuestbookPage_Returns200WithContents()
    {
        $pdo = (new PDOFactory())->getPDO();
        $pdo->query('TRUNCATE TABLE messages');

        $record = [
            'name' => 'test name 1',
            'email' => 'test@test.test 1',
            'message' => 'test message 1',
            'created_at' => '2018-08-28 10:00:00',
        ];

        $statement = $pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');
        $statement->execute($record);

        $response = $this->runApp('GET', '/guestbook');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('test name 1', $response->getBody().'');
    }
}