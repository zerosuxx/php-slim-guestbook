<?php

namespace Guestbook\Action;

use Guestbook\Dao\PDOFactory;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheckAction
{
    /**
     * @var PDOFactory
     */
    private $pdoFactory;

    public function __construct(PDOFactory $pdoFactory)
    {
        $this->pdoFactory = $pdoFactory;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        try {
            $this->pdoFactory->getPDO()->query('SELECT 1');
            $response->write('OK');
        } catch (\PDOException $ex) {
            $response = $response->withStatus(500);
        }
        return $response;
    }
}