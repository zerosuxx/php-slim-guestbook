<?php

namespace Guestbook\Dao;

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
     * @param string $name
     * @param string $email
     * @param string $message
     * @param \DateTime $createdAt
     * @return bool
     */
    public function saveMessage(string $name, string $email, string $message, \DateTime $createdAt)
    {
        $statement = $this->pdo->prepare('INSERT INTO messages (name, email, message, created_at) 
                                          VALUES (:name, :email, :message, :created_at)');

        $record = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => $createdAt->format('Y-m-d H:i:s')
        ];
        return $statement->execute($record);
    }


}