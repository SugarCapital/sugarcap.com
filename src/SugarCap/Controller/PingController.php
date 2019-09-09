<?php
namespace Labs\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Interop\Container\ContainerInterface;

/**
 * PingController for basic health check.
 */
class PingController
{

    public function __construct(ContainerInterface $c) {
        // could do something with the container $c...
    }

    /**
     * Respond with 200 OK
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response {
        return $response->write('pong');
    }
}
