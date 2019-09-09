<?php

namespace SugarCap\Middleware;

use Slim\Csrf\Guard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CsrfGuard extends Guard
{
    /** @var array $whitelist */
    protected $whitelist;
    public function __construct(
        iterable $whitelist,
        $prefix = 'csrf',
        &$storage = null,
        callable $failureCallable = null,
        $storageLimit = 200,
        $strength = 16,
        $persistentTokenMode = false)
    {
        parent::__construct($prefix, $storage, $failureCallable, $storageLimit, $strength, $persistentTokenMode);
        $this->whitelist = $whitelist;
    }

    /**
     * Simplest hacky way to whitelist some urls so they don't fail Csrf
     * this is used incoming API request (like from AWS SNS) instead of
     * coming from a web-browser client.  Ideally we would have some kind
     * of throttle guard or something in front of this ur.
     *
     * I'm sure that there is a much more elegant slim way to do this.
     *
     * @param  ServerRequestInterface $request  PSR7 request
     * @param  ResponseInterface      $response PSR7 response
     * @param  callable               $next     Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response, callable $next) : Response {
        // HACK!  bypass the product post for now since i don't know why it is timing out.
        $parts = explode('/', $request->getUri()->getPath());
        $isProductPost = count($parts) === 5
            && $parts[1][0] === '@'
            && ($parts[4] === 'edit' || $parts[4] === 'authorize' || $parts[4] === 'play')
            && $request->getMethod() !== 'GET';

        $isProductPost = $isProductPost || (count($parts) === 5
            && $parts[1] === 'cast'
            && $parts[2] === 'authorize');

        if (!$isProductPost && !in_array($request->getUri()->getPath(), $this->whitelist)) { // test if path in in the whitelist
            return parent::__invoke($request, $response, $next);
        }

        return $next($request, $response);
    }
}
