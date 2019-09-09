<?php

namespace SugarCap\Middleware;

/**
 * Middleware to Redirect www.host.org/a?b to host.org/a?b
 */
class DomainNameRedirect
{
    public function __invoke($request, $response, $next) {
        $uri = $request->getUri();
        $host = $uri->getHost();
        if (stripos($host, 'www.') === 0) {
            $parts = explode('.', $host);
            array_shift($parts);
            $redirectToUri = $uri->withHost(implode('.', $parts));
            return $response->withRedirect($redirectToUri, 301); // permanent
        }
        return $next($request, $response);
    }
}
