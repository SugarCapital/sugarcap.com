<?php

namespace SugarCap\Middleware;

class XFrameOptions
{
    /**
     * Add the XFrameOption Deny to header
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $haystack = $request->getUri()->getPath();
        $needle = '/card';

        if (strpos($haystack, $needle) === 0) {
            return $next($request, $response);
        }

        return $next($request, $response->withAddedHeader('X-Frame-Options', 'Deny'));
    }
}
