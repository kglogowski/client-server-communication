<?php

namespace CSC\Protocol\Rest\Auth\Response\Factory;

use CSC\Protocol\Rest\Auth\Security\Authenticator\SSOAuthenticator;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class SSOClearCookieFactory
 */
class SSOClearCookieFactory implements SSOCookieFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $name, string $token): Cookie
    {
        $cookieName = sprintf('%s%s', strtoupper($name), SSOAuthenticator::TOKEN_POSTFIX);
        $token = null;
        $expires = 1;
        $path = '/';
        $domain = null;

        $cookie = new Cookie($cookieName, $token, $expires, $path, $domain);

        return $cookie;
    }
}
