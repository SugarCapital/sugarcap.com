<?php

namespace SugarCap\Middleware;

class IsGdprRequest
{
    private $codes;
    private $c;

    public function __construct($c)
    {
        $this->c = $c;
        $this->codes = ["AT" => 1, "BE" => 1, "BG" => 1, "CY" => 1, "CZ" => 1,
            "DE" => 1, "DK" => 1, "EE" => 1, "ES" => 1, "FI" => 1, "FR" => 1,
            "GB" => 1, "GR" => 1, "HR" => 1, "HU" => 1, "IE" => 1, "IT" => 1,
            "LT" => 1, "LU" => 1, "LV" => 1, "MT" => 1, "NL" => 1, "PL" => 1,
            "PT" => 1, "RO" => 1, "SE" => 1, "SI" => 1, "SK"
        ];
    }

    /**
     * Indicate if this request originates from a
     * GDPR jurisdiction
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next) {
        $gdpr = false;
        if($request->hasHeader('CloudFront-Viewer-Country')) {
            $headerCodes = $request->getHeader('CloudFront-Viewer-Country');
            foreach($headerCodes as $headerCode) {
                if($this->isGdpr($headerCode)) {
                    $gdpr = true;
                    break;
                }
            }
        }

        $this->c->renderer->addData(['gdpr' => $gdpr]);
        return $next($request, $response);
    }

    private function isGdpr($countryCode) {
        return !empty($countryCode) && array_key_exists($countryCode, $this->codes);
    }
}
