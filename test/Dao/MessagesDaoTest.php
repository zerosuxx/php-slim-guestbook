<?php

namespace Test\Dao;


use Guestbook\Dao\MessagesDao;
use Guestbook\Dao\PDOFactory;
use Guestbook\Entity\Message;
use PDO;
use PHPUnit\Framework\TestCase;

class MessagesDaoTest extends TestCase
{

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var MessagesDao
     */
    private $dao;

    protected function setUp()
    {
        $this->pdo = (new PDOFactory())->getPDO();
        $this->pdo->query('TRUNCATE TABLE messages');

        $this->dao = new MessagesDao($this->pdo);
    }

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

        $statement = $this->pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');
        $statement->execute($records[0]);


        $result = $this->dao->getMessages();

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


        $statement = $this->pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');

        foreach($records as $record) {
            $statement->execute($record);
        }

        $result = $this->dao->getMessages();

        $this->assertEquals($records[0], $result[2]);
        $this->assertEquals($records[1], $result[1]);
        $this->assertEquals($records[2], $result[0]);
        $this->assertEquals(3, count($records));
    }

    /**
     * @test
     */
    public function saveMessage_WithParameters_SavesMessageToDb()
    {
        $message = new Message('Joe', 'joe@joe.hu', 'test message');
        $saved = $this->dao->saveMessage($message);
        $this->assertTrue($saved);

        $statement = $this->pdo->query('SELECT name, message, email, created_at FROM messages ORDER BY created_at DESC');
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->assertEquals($message->getName(), $result[0]['name']);
        $this->assertEquals($message->getEmail(), $result[0]['email']);
        $this->assertEquals($message->getMessage(), $result[0]['message']);
        $this->assertNotEmpty($result[0]['created_at']);
        $this->assertEquals(1, $statement->rowCount());

    }
}