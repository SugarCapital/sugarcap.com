<?php
use Slim\Flash\Messages;
use Slim\Csrf\Guard;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Psr\Cache\CacheItemPoolInterface;
use CaseHelper\CaseHelperFactory;
use Mailgun\Mailgun;

use SugarCap\TemplateFunctions\Version;

use SugarCap\Middleware\CsrfGuard;
use SugarCap\Middleware\CsrfFail;

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    // $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    // $stream = new Monolog\Handler\StreamHandler($settings['path'], $settings['level']);
    // $formatter = new Monolog\Formatter\LineFormatter();
    // $formatter->combineContextAndExtra(true);
    // $stream->setFormatter($formatter);
    // $logger->pushHandler($stream);

    return $logger;
};

// Register provider
$container['flash'] = function () : Messages {
    return new Messages();
};

$container['cache'] = function ($c) : CacheItemPoolInterface {
    // use the default location.
    $cache = new FilesystemAdapter('', 60 * 5);
    return $cache;
};

$container['csrf'] = function ($c) : Guard {
    $foo = null;
    $guard = new CsrfGuard(
        $c->settings['csrfWhitelist'],
        'csrf',
        $foo,
        new CsrfFail($c)
    );

    return $guard;
};

$container['cookie'] = function ($c) {
    $request = $c->get('request');
    return new \Slim\Http\Cookies($request->getCookieParams());
};

$container['mailGunService'] = function ($c) {
    $strategies = [\Http\Discovery\Strategy\CommonClassesStrategy::class];
    \Http\Discovery\ClassDiscovery::setStrategies($strategies);
    return Mailgun::create('key-3a1c764289259ee2532fd1fd28d12c34');
};

$container['googleService'] = function ($c) {
    $googleService = new GoogleService($c);
    return $googleService;
};

$container['algoliaService'] = function ($c) {
    $algoliaService = new AlgoliaService($c);
    return $algoliaService;
};

// view renderer
$container['renderer'] = function ($c) {
    // find another way to put this in.  this
    // whole function needs to be refactored into its
    // discreet jobs.  this is the init of the
    // renderer on first use.
    $nameKey = $c->csrf->getTokenNameKey();
    $valueKey = $c->csrf->getTokenValueKey();

    $csrfData = [
        'csrfNameKey' => $nameKey,
        'csrfNameValue' => $c->csrf->getTokenName(),
        'csrfValueKey' => $valueKey,
        'csrfValueValue' => $c->csrf->getTokenValue(),
    ];

    if (isset($_SESSION['gtag'])) {
        $gtag = $_SESSION['gtag'];
        unset($_SESSION['gtag']);
    }

    $globalTemplateVars = [
        'flash'         => $c->flash,
        'cookie'        => $c->cookie,
        'settings'      => $c->settings,
        'gtag'          => $gtag ?? null,
    ];

    $settings = $c->get('settings')['renderer'];
    $phpView = new League\Plates\Engine($settings['template_path']);
    $phpView->addData($globalTemplateVars);
    // re-arrange...refactor...
    $phpView->addData($csrfData);
    $phpView->setFileExtension('tpl');
    $phpView->registerFunction('stripProtocol', function ($string) {
        $cleanString = new StripProtocol($string);
        return $cleanString;
    });

    $phpView->registerFunction('plural', function ($count, $phrase, $singular, $plural) {
        $plural = new Plural($count, $phrase, $singular, $plural);
        return $plural;
    });
    $phpView->registerFunction('cdnImage', function ($string, $size) {
        return Helper::cdnImage($string, $size);
    });
    $phpView->registerFunction('shortenNumber', function ($string) {
        return Helper::number_format_short($string);
    });
    $phpView->registerFunction('relativeDate', function ($date) {
        return Helper::relativeDate($date);
    });
    $ch = CaseHelperFactory::make(CaseHelperFactory::INPUT_TYPE_CAMEL_CASE);
    $phpView->registerFunction('kebabCase', function ($string) use ($ch) {
        return $ch->toKebabCase($string);
    });
    $phpView->registerFunction('version', new Version());

    return $phpView;
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        // check if /@handle has been encoded to /%40handle
        if (substr($request->getUri()->getPath(), 0, 4) === '/%40') {
            $uri = $request->getUri();
            $decodedUri = $uri->withPath(urldecode($request->getUri()->getPath()));
            return $response->withRedirect($decodedUri, 302);

        }
        $notFound = $c->renderer->render('404', []);
        $page = $c->renderer->render('index', ['body' => $notFound]);
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write($page);
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $notFound = $c->renderer->render('403', []);
        $page = $c->renderer->render('index', ['body' => $notFound]);
        return $c['response']
            ->withStatus(403)
            ->withHeader('Content-Type', 'text/html')
            ->write($page);
    };
};


$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        error_log($error->getMessage());
        if (getenv('PHP_ENV') === 'production') {
            $notFound = $c->renderer->render('500', []);
            $page = $c->renderer->render('index', ['body' => $notFound]);
            return $c['response']
                ->withStatus(500)
                ->withHeader('Content-Type', 'text/html')
                ->write($page);
        }

        return $response;
    };
};
