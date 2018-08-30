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
    public function getMessages_WithOneMessage_ReturnsMessage()
    {
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test@test.test 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-28 10:00:00',
            ]
        ];

        $pdo = (new PDOFactory())->getPDO();

        $pdo->query('TRUNCATE TABLE messages');
        $statement = $pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');
        $statement->execute($records[0]);

        $dao = new MessagesDao($pdo);

        $result = $dao->getMessages();

        $this->assertEquals($records, $result);
    }

    /**
     * @test
     */
    public function getMessages_WithMultipleMessages_ReturnMessagesByCreatedAt()
    {
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test@test.test 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-28 10:00:00',
            ],
            [
                'name' => 'test name 2',
                'email' => 'test@test.test 2',
                'message' => 'test message 2',
                'created_at' => '2018-08-29 10:00:00',
            ],
            [
                'name' => 'test name 3',
                'email' => 'test@test.test 3',
                'message' => 'test message 3',
                'created_at' => '2018-08-30 10:00:00',
            ]
        ];

        $pdo = (new PDOFactory())->getPDO();

        $pdo->query('TRUNCATE TABLE messages');
        $statement = $pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');

        foreach($records as $record) {
            $statement->execute($record);
        }

        $dao = new MessagesDao($pdo);

        $result = $dao->getMessages();

        $this->assertEquals($records[0], $result[2]);
        $this->assertEquals($records[1], $result[1]);
        $this->assertEquals($records[2], $result[0]);
        $this->assertEquals(3, count($records));
    }
}