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
        $templateArgs['angel'] = [
            ['name' => 'Everlane', 'link' => 'https://www.everlane.com', 'img' => "/imgs/logos/everlane.jpg" ],
            ['name' => 'Olive & June', 'link' => 'https://www.oliveandjune.com', 'img' => "/imgs/logos/olive-and-june.jpg"],
            ['name' => 'Afterpay', 'link' => 'https://www.afterpay.com', 'img' => "/imgs/logos/afterpay.jpg"],
            ['name' => 'Roadster', 'link' => 'https://www.roadster.com', 'img' => "/imgs/logos/roadster.jpg"],
            ['name' => 'Fabkids', 'link' => 'https://www.afterpay.com', 'img' => "/imgs/logos/fab-kids.jpg"],
            ['name' => 'True Botanicals', 'link' => 'https://www.truebotanicals.com', 'img' => "/imgs/logos/true-botanicals.jpg"],
            ['name' => 'ShopStyle', 'link' => 'https://www.shopstyle.com', 'img' => "/imgs/logos/shopstyle.png"],
            ['name' => 'Lolli', 'link' => 'https://www.Lolli.com', 'img' => "/imgs/logos/lolli.jpg"],
            ['name' => 'The Assembly', 'link' => 'https://www.theassembly.com', 'img' => "/imgs/logos/the-assembly.jpg"],
            ['name' => 'Leap', 'link' => 'https://www.leapinc.com', 'img' => "/imgs/logos/leap.jpg"],
            ['name' => 'Small Door Vet', 'link' => 'https://www.smalldoorvet.com', 'img' => "/imgs/logos/small-door-vet.jpg"],
            ['name' => 'Tribe Dynamics', 'link' => 'https://www.tribedynamics.com', 'img' => "/imgs/logos/tribe-dynamics.jpg"],
            ['name' => 'Argent', 'link' => 'https://www.argentwork.com', 'img' => "/imgs/logos/argent.jpg"],
            ['name' => 'POPSUGAR', 'link' => 'https://www.popsugar.com', 'img' => "/imgs/logos/popsugar.jpg"],
            ['name' => 'Optimizely', 'link' => 'https://www.optimizely.com', 'img' => "/imgs/logos/optimizely.jpg"],
            ['name' => 'Tracksmith', 'link' => 'https://www.tracksmith.com', 'img' => "/imgs/logos/tracksmith.jpg"],
            ['name' => 'Foxeye', 'link' => 'https://www.foxeyerobotics.com', 'img' => "/imgs/logos/foxeye.png"],
            
        ];
        $templateArgs['fund1'] = [
            ['name' => 'Black Wolf', 'link' => 'https://blackwolfnation.com', 'img' => "/imgs/logos/blackwolf.jpg"],
            ['name' => 'Clyde', 'link' => 'https://www.joinclyde.com/', 'img' => "/imgs/logos/clyde.jpg"],
            ['name' => 'Kinship', 'link' => 'https://lovekinship.com/', 'img' => "/imgs/logos/kinship.jpg"],
            ['name' => 'Shopping Gives', 'link' => 'https://shoppinggives.com/', 'img' => "/imgs/logos/shopping-gives.jpg"],
            ['name' => 'Citizen Science', 'link' => 'https://thecitizenscience.com', 'img' => "/imgs/logos/citizenscience.png"],
            ['name' => 'Co-op', 'link' => 'https://www.coopcommerce.co', 'img' => "/imgs/logos/coop.png"],
            ['name' => 'Brightland', 'link' => 'https://brightland.co', 'img' => "/imgs/logos/brightland.jpg"],
            ['name' => 'Builder.io', 'link' => 'https://builder.io', 'img' => "/imgs/logos/builderio.png"],
            ['name' => 'Jupiter', 'link' => 'https://hellojupiter.com', 'img' => "/imgs/logos/jupiter.png"],
            ['name' => 'Caraway', 'link' => 'https://www.carawayhome.com', 'img' => "/imgs/logos/caraway.jpg"],
            ['name' => 'Judy', 'link' => 'https://readyjudy.com', 'img' => "/imgs/logos/judy.jpg"],
            ['name' => 'Polyops', 'link' => 'https://polyoperations.com', 'img' => "/imgs/logos/polyops.png"],
            ['name' => 'Starface', 'link' => 'https://starface.world', 'img' => "/imgs/logos/starface.jpg"],
            ['name' => 'Fast', 'link' => 'https://fast.co', 'img' => "/imgs/logos/fast.jpg"],
            ['name' => 'Frame', 'link' => 'https://www.tryframe.com/', 'img' => "/imgs/logos/frame.jpg"],
        ];

        usort($templateArgs['angel'], function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });

        usort($templateArgs['fund1'], function($a, $b) {
            return strcmp($a["name"], $b["name"]);
        });

        $args['body'] = $this->renderer->render('home', $templateArgs);
        return $response->write($this->renderer->render('index', $args));
    }


}
