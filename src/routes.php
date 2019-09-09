<?php
// use SugarCap\Middleware\CsrfHeaders;
use SugarCap\Controller\PingController;
use SugarCap\Controller\HomeController;

$app->get('/', HomeController::class);
$app->get('/ping', PingController::class);
