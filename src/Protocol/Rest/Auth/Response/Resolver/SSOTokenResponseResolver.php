<?php

namespace CSC\Protocol\Rest\Auth\Response\Resolver;

use CSC\DependencyInjection\Configuration;
use CSC\Model\UserAccessToken;
use CSC\Protocol\Rest\Auth\Response\Factory\SSOCookieFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SSOTokenResponseResolver
 */
class SSOTokenResponseResolver implements TokenResponseResolverInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var UserAccessToken
     */
    protected $accessToken;

    /**
     * @var SSOCookieFactoryInterface
     */
    protected $cookieFactory;

    /**
     * SSOTokenResponseResolver constructor.
     *
     * @param array                     $config
     * @param SSOCookieFactoryInterface $cookieFactory
     */
    public function __construct(array $config, SSOCookieFactoryInterface $cookieFactory)
    {
        $this->config = $config;
        $this->cookieFactory = $cookieFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccessToken(UserAccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Response $response): Response
    {
        if (null === $this->accessToken || false === $this->config[Configuration::INDEX_USE_SSO]) {
            return $response;
        }

        $cookie = $this->cookieFactory->create($this->accessToken->getProviderKey(), $this->accessToken->getToken());
        $response->headers->setCookie($cookie);

        return $response;
    }
}
