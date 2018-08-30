<?php

namespace Test\Dao;


use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use PHPUnit\Framework\TestCase;

class MessagesDaoTest extends TestCase
{

    /**
     * @test
     */
    public function getMessages_ReturnsMessages()
    {
        $record = [
            'name' => 'test name 1',
            'email' => 'test@test.test 1',
            'message' => 'test message 1',
            'created_at' => '2018-08-28 10:00:00',
        ];

        $pdo = (new PDOFactory())->getPDO();

        $pdo->query('TRUNCATE TABLE messages');
        $statement = $pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');
        $statement->execute($record);

        $dao = new MessagesDao($pdo);

        $result = $dao->getMessages();

        $this->assertEquals($record, $result[0]);
    }
}