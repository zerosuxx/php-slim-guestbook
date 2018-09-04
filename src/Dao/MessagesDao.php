<?php

namespace Guestbook\Dao;

use Guestbook\Entity\Message;

/**
 * Class MessagesDao
 * @package Guestbook\Dao
 */
class MessagesDao
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * MessagesDao constructor.
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        $statement = $this->pdo->query('SELECT name, email, message, created_at FROM messages ORDER BY created_at DESC');
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function saveMessage(Message $message)
    {
        $statement = $this->pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');

        $record = [
            'name' => $message->getName(),
            'email' => $message->getEmail(),
            'message' => $message->getMessage(),
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ];
        return $statement->execute($record);
    }

}