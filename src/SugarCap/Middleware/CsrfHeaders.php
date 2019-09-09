<?php

namespace SugarCap\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

class CsrfHeaders
{
    /** @var Guard $csrf */
    protected $csrf;

    public function __construct(ContainerInterface $container) {
        $this->csrf = $container->csrf;
    }

    /**
     * Add Csrf tokens to headers
     *
     * @param  ServerRequestInterface $request  PSR7 request
     * @param  ResponseInterface      $response PSR7 response
     * @param  callable               $next     Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next) : Response {
        if ($request->isPost()
         && !($response->hasHeader('X-CSRF-NAME-KEY')
            && $response->hasHeader('X-CSRF-NAME-VALUE')
            && $response->hasHeader('X-CSRF-VALUE-KEY')
            && $response->hasHeader('X-CSRF-VALUE-VALUE'))) {
            $nameKey = $this->csrf->getTokenNameKey();
            $valueKey = $this->csrf->getTokenValueKey();

            $response = $response
                ->withHeader('X-CSRF-NAME-KEY', $nameKey)
                ->withHeader('X-CSRF-NAME-VALUE', $request->getAttribute($nameKey))
                ->withHeader('X-CSRF-VALUE-KEY', $valueKey)
                ->withHeader('X-CSRF-VALUE-VALUE', $request->getAttribute($valueKey));
        }

        return $next($request, $response);
    }
}
