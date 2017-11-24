<?php

namespace CSC\Protocol\Rest\Auth\Security\Authenticator;

use CSC\Protocol\Rest\Auth\Interfaces\TokenKeyAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class SSOAuthenticator
 */
abstract class SSOAuthenticator extends AbstractUserAuthenticator implements TokenKeyAware
{
    const
        TOKEN_NAME = 'TOKEN',
        TOKEN_POSTFIX = '_SSOID',
        CONF_USE_SSO = 'use_sso'
    ;

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($this->isAlreadyAuthenticated()) {
            return null;
        }

        $tokenKey = sprintf('%s%s', $this->getTokenKey(), static::TOKEN_POSTFIX);
        $token = $request->cookies->get($tokenKey);
        if (null === $token || false === $token) {
            return null;
        }

        return [
            'token' => $token,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];

        $user =  $userProvider->loadUserByUsername($token);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }
}
