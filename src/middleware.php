<?php

use SugarCap\Middleware\ConditionalHttps;
use SugarCap\Middleware\XFrameOptions;
use SugarCap\Middleware\CsrfHeaders;
use SugarCap\Middleware\StaleSessionRedirect;
use SugarCap\Middleware\DomainNameRedirect;
use SugarCap\Middleware\IsGdprRequest;
use SugarCap\Middleware\AddResponseHeaders;

$app->add(AddResponseHeaders::class);
$app->add(IsGdprRequest::class);
$app->add(DomainNameRedirect::class);
$app->add(CsrfHeaders::class);
$app->add($app->getContainer()->get('csrf'));
$app->add(XFrameOptions::class);
$app->add(ConditionalHttps::class);
$app->add(StaleSessionRedirect::class);
