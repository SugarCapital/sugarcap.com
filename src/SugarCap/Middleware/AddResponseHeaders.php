<?php

namespace SugarCap\Middleware;

class AddResponseHeaders
{

    /**
     *
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Add Headers to the Response
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $response = $response->withAddedHeader('vary', 'Cookie, User-Agent');
        return $next($request, $response);
    }
}
