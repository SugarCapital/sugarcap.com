<?php

namespace SugarCap\Middleware;

class RequireMasterKeyHeader
{
    public function __construct($c)
    {
        $this->settings = $c->settings;
    }
    public function __invoke($request, $response, $next) {
        $masterKey = $this->settings['parse']['masterKey'];
        $headers = $request->getHeaders();
        if(array_key_exists('HTTP_X_PARSE_MASTER_KEY', $headers) && in_array($masterKey, $headers['HTTP_X_PARSE_MASTER_KEY'])) {
            return $next($request, $response);
        }
        return $response->withStatus(403, 'Master Key Required');
    }
}
