<?php

namespace CSC\Protocol\Rest\Auth\Response\Factory;

use Symfony\Component\HttpFoundation\Cookie;

/**
 * Interface SSOCookieFactoryInterface
 */
interface SSOCookieFactoryInterface
{
    /**
     * @param string $name
     * @param string $token
     *
     * @return Cookie
     */
    public function create(string $name, string $token): Cookie;
}