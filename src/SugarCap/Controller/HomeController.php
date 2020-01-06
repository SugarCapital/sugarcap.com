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
        $templateArgs['companies'] = [
            ['name' => 'Everlane', 'link' => 'https://www.everlane.com', 'img' => "/imgs/logos/everlane.jpg"],
            ['name' => 'Olive & June', 'link' => 'https://www.oliveandjune.com', 'img' => "/imgs/logos/olive-and-june.jpg"],
            ['name' => 'Afterpay', 'link' => 'https://www.afterpay.com', 'img' => "/imgs/logos/afterpay.jpg"],
            ['name' => 'Roadster', 'link' => 'https://www.roadtser.com', 'img' => "/imgs/logos/roadster.jpg"],
            ['name' => 'Fabkids', 'link' => 'https://www.afterpay.com', 'img' => "/imgs/logos/fab-kids.jpg"],
            ['name' => 'True Botanicals', 'link' => 'https://www.truebotanicals.com', 'img' => "/imgs/logos/true-botanicals.jpg"],
            ['name' => 'ShopStyle', 'link' => 'https://www.shopstyle.com', 'img' => "/imgs/logos/shopstyle.jpg"],
            ['name' => 'Lolli', 'link' => 'https://www.Lolli.com', 'img' => "/imgs/logos/lolli.jpg"],
            ['name' => 'The Assembly', 'link' => 'https://www.theassembly.com', 'img' => "/imgs/logos/the-assembly.jpg"],
            ['name' => 'Leap', 'link' => 'https://www.leapinc.com', 'img' => "/imgs/logos/leap.jpg"],
            ['name' => 'Small Dog Vet', 'link' => 'https://www.smalldoorvet.com', 'img' => "/imgs/logos/small-door-vet.jpg"],
            ['name' => 'Tribe Dynamics', 'link' => 'https://www.tribedynamics.com', 'img' => "/imgs/logos/tribe-dynamics.jpg"],
            ['name' => 'Argent', 'link' => 'https://www.argent.com', 'img' => "/imgs/logos/argent.jpg"],
            ['name' => 'POPSUGAR', 'link' => 'https://www.popsugar.com', 'img' => "/imgs/logos/popsugar.jpg"],
            ['name' => 'Fast', 'link' => 'https://www.fast.co', 'img' => "/imgs/logos/fast.jpg"],
            ['name' => 'Optimizely', 'link' => 'https://www.optimizely.com/', 'img' => "/imgs/logos/optimizely.jpg"],
            ['name' => 'Tracksmith', 'link' => 'https://www.tracksmith.com/', 'img' => "/imgs/logos/tracksmith.jpg"],
            ['name' => 'Brightland', 'link' => 'https://brightland.co/', 'img' => "/imgs/logos/brightland.jpg"],
            ['name' => 'Builder.io', 'link' => 'https://builder.io/', 'img' => "/imgs/logos/builderio.png"],
        ];

        usort($templateArgs['companies'], function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });
        $args['body'] = $this->renderer->render('home', $templateArgs);
        return $response->write($this->renderer->render('index', $args));
    }


}
