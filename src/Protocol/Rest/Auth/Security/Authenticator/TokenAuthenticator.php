<?php

namespace CSC\Protocol\Rest\Auth\Security\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class TokenAuthenticator
 */
abstract class TokenAuthenticator extends AbstractUserAuthenticator
{
    const TOKEN_HEADER_NAME = 'Header';
    const TYPE_HEADER_NAME = 'Type-token';

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($this->isAlreadyAuthenticated()) {
            return null;
        }

        $token = $request->headers->get(static::TOKEN_HEADER_NAME);
        if (null === $token) {
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

        $user = $userProvider->loadUserByUsername($token);

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