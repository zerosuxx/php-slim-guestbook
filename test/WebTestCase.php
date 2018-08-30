<?php

namespace Test;

use Guestbook\AppBuilder;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

trait WebTestCase
{

    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        $app = (new AppBuilder())->build();

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }
}