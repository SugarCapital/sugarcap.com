<?php

use Parse\ParseClient;

$isProd = getenv('PHP_ENV') === 'production';
$isDevelopment = getenv('PHP_ENV') === 'development';

$settings = [
    'packageJs' => $isProd || $isDevelopment,
    'gaProfileId' => $isProd ? 183928791 : 188970407,
    'displayErrorDetails' => true, // set to false in production
    'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    // Renderer settings
    'renderer' => [
        'template_path' => __DIR__ . '/../templates',
    ],
    // Monolog settings
    'logger' => [
        'name' => 'slim-app',
        'path' => 'php://stdout',
        'level' => \Monolog\Logger::DEBUG,
    ],
    'cache' => ['ttl' => 1000 * 60, /* 1 min in ms */ ],
    'csrfWhitelist' => [],
    // 'routerCacheFile' => __DIR__ .'/../.router-cache.php',
];

if ($isDevelopment) {
    $settings['routerCacheFile'] = __DIR__ . '/../.router-cache.php';
}

if ($isProd) {
    $settings['displayErrorDetails'] = false;
    $settings['routerCacheFile'] = __DIR__ . '/../.router-cache.php';
}

return [
    'settings' => $settings,
];
