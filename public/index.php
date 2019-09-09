<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

if ($_SERVER['HTTP_HOST'] == 'ratemyinstructor.co' || $_SERVER['HTTP_HOST'] == 'origin.sugarcap.com') {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://sugarcap.com/instructors?ref=ratemyinstructor");
    return;
}

require __DIR__ . '/../vendor/autoload.php';

use Aws\DynamoDb\SessionHandler;

$sdk = new Aws\Sdk(['region' => 'us-east-1']);

$yearInSeconds = intval('3.154e+7');
ini_set('session.cookie_lifetime', $yearInSeconds);

// if (getenv('PHP_ENV') === 'production') {
if (PHP_OS !== 'Darwin') { // lame hack
    ini_set('session.gc_maxlifetime', $yearInSeconds);
    $dynamoDb = $sdk->createDynamoDb(['version' => '2012-08-10']);
    $sessionHandler = SessionHandler::fromClient($dynamoDb, [
        'table_name' => 'LabPHPSharedSession'
    ]);
    $sessionHandler->register();
}

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();
$container['awsSdk'] = $sdk;

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require_once __DIR__ . '/../src/routes.php';

// Run app
$app->run();
