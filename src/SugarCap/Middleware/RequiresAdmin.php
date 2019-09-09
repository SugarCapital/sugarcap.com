<?php

namespace SugarCap\Middleware;

use Slim\Exception\MethodNotAllowedException;

use \Parse\ParseUser;

class RequiresAdmin
{
    public function __construct($container) {
        $this->flash = $container->flash;
    }

    public function __invoke($request, $response, $next) {
        $currentUser = ParseUser::getCurrentUser();
        if (empty($currentUser) || $currentUser->isAdmin == false) {
            throw new MethodNotAllowedException($request, $response, []);
        }
        return $next($request, $response);
    }
}
