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


}