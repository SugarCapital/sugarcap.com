<?php

namespace SugarCap\Middleware;

use \SugarCap\Model\SugarCapUser;

class RequiresRegistration
{
    public function __construct($container, $redirectLocation = '/sign-up') {
        $this->flash = $container->flash;
        $this->redirectLocation = $redirectLocation;
    }

    public function __invoke($request, $response, $next) {
        if (SugarCapUser::isUserAnonymous()) {
            $_SESSION['redirectUrl'] = $_SERVER['REQUEST_URI'];

            if (self::_isCheckoutFlow()) {
                return $response->withRedirect('/checkout-register', 302);
            }

            if (self::_isItemBuyNow()) {
                return $response->withRedirect(str_replace('/checkout', '/register', $_SERVER['REQUEST_URI']), 302);
            }

            $message = $this->redirectLocation === '/sign-in' ? 'Please sign in first.' : 'Please register first.';
            $this->flash->addMessage('', $message);
            return $response->withRedirect($this->redirectLocation, 302);
        }
        return $next($request, $response);
    }

    private function _isCheckoutFlow() {
        return $_SERVER['REQUEST_URI'] === '/checkout';
    }

    private function _isItemBuyNow() {
        return strpos($_SERVER['REQUEST_URI'], '/checkout') > 0 ;
    }
}
