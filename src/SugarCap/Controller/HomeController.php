<?php

namespace SugarCap\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

use SugarCap\Helper;
use SugarCap\Model\SugarCapUser;
use SugarCap\Service\SignCookies;

class HomeController
{
    public function __construct($c) {
        $this->renderer = $c->renderer;
        $this->cache = $c->cache;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $args['body'] = $this->renderer->render('home', $args);
        return $response->write($this->renderer->render('index', $args));
    }

}
