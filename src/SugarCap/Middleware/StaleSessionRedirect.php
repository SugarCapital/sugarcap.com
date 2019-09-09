<?php

namespace SugarCap\Middleware;

use \Parse\ParseException;

class StaleSessionRedirect
{
    /**
     * Catch a Parse stale session error and redirect the request
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        try {
            return $next($request, $response);
        } catch (ParseException $e) {
            if ($e->getCode() === 209) {
                return $response->withRedirect('/sign-out', 302);
            }

            throw $e;
        }
    }
}
