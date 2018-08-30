<?php

namespace Guestbook\Dao;

use PDO;

/**
 * Class PDOFactory
 * @package Guestbook\Dao
 */
class PDOFactory
{
    /**
     * @var \PDO
     */
    private $pdo = null;

    /**
     * @var \PDO
     */
    private $pdoWithoutDatabase = null;

    /**
     * @return \PDO
     */
    public function getPDO(): \PDO
    {
        if(null === $this->pdo) {
            $this->pdo = $this->buildPDO(getenv('DB_NAME'));
        }
        return $this->pdo;
    }

    /**
     * @return \PDO
     */
    public function getPDOWithoutDatabase(): \PDO
    {
        if(null === $this->pdoWithoutDatabase) {
            $this->pdoWithoutDatabase = $this->buildPDO();
        }
        return $this->pdoWithoutDatabase;
    }

    private function buildPDO($dbName = null) {
        $pdo = new PDO($this->getDsn($dbName), getenv('DB_USER'), getenv('DB_PASSWORD'));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    private function getDsn($dbName = null) {
        return $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST'), $dbName);
    }
}