<?php

namespace Guestbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheckAction
{
    public function __invoke(Request $request, Response $response, array $args)
    {
        return $response;
    }
}