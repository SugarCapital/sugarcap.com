<?php

namespace SugarCap\Middleware;

use SugarCap\Model\SugarCapUser;

class RoutePermission
{
    protected $roleName;

    public function __construct($roleName, $container) {
        $this->roleName = $roleName;
        $this->c = $container;
    }

    /**
     * Verify that a user has permission to view a path
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $authorized = false;
        $user = SugarCapUser::getCurrentUser();

        if ($user) {
            $authorized = $user->hasRole($this->roleName);
        }

        if (!$authorized) {
            $page = $this->c->renderer->render('index', ['body' => '<div class="container">unauthorized</div>']);
            return $response->write($page)
                ->withHeader('Content-Type', 'text/html')
                ->withStatus(403);
        }

        return $next($request, $response);
    }
}
