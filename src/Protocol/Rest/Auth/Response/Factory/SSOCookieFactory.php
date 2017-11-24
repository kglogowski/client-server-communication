<?php

namespace CSC\Protocol\Rest\Auth\Response\Factory;

use CSC\Protocol\Rest\Auth\Security\Authenticator\SSOAuthenticator;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class SSOCookieFactory
 */
class SSOCookieFactory implements SSOCookieFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(string $name, string $token): Cookie
    {
        $cookieName = sprintf('%s%s', strtoupper($name), SSOAuthenticator::TOKEN_POSTFIX);
        $expires = 0;
        $path = '/';
        $domain = null;

        $cookie = new Cookie($cookieName, $token, $expires, $path, $domain);

        return $cookie;
    }
}
