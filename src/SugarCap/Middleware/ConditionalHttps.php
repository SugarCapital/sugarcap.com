<?php

namespace SugarCap\Middleware;

use Psr7Middlewares\Middleware;

class ConditionalHttps
{
    /**
     * Redirect Http to Https most of the time
     *
     * This shouldn't be in middleware.  Should be in the proxy config, but
     * it is way to hard to figure out how to do that with Beanstalk.
     *
     * Kubernetes here I come!
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $shouldRedirect =
          PHP_OS !== 'Darwin' &&
          $request->getUri()->getPath() !== '/ping';

        if ($shouldRedirect) {
            $https = Middleware::Https(true)
                ->includeSubdomains()
                ->checkHttpsForward(true);
            return $https($request, $response, $next);
        }

        return $next($request, $response);
    }
}
