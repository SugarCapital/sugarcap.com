<?php

namespace SugarCap\Middleware;

use Slim\Container;


class CsrfFail {
    public function __construct(Container $c)
    {
        $this->c = $c;
    }
    public function __invoke($request, $response, $next) {
        if (stripos($request->getServerParam('HTTP_ACCEPT'), 'text/javascript') !== -1) {
            $msg = ['errorMessage' => 'Failed CSRF check'];
            return $response->withJson($msg, 400);
        }

        $args['message'] = 'Failed CSRF check!';
        $args['body'] = $this->c->renderer->render('csrf-fail', $args);
        return $response->withStatus(400)->write($this->c->renderer->render('index', $args));
    }
}
