<?php

namespace CSC\Protocol\Rest\Auth\Security\Authenticator;

use CSC\Protocol\Rest\Auth\Security\Checker\TokenChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class TokenAuthenticator
 */
abstract class TokenAuthenticator extends AbstractUserAuthenticator
{
    const TOKEN_HEADER_NAME = 'Authorization';
    const TYPE_HEADER_NAME = 'Type-token';

    const TOKEN_TYPE_BEARER = 'Bearer';
    const TOKEN_TYPE_BASIC = 'Basic';

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        if ($this->isAlreadyAuthenticated()) {
            return null;
        }

        $token = $request->headers->get(static::TOKEN_HEADER_NAME);
        list($token) = sscanf($token, $this->getTokenType() . ' %s');

        if (null === $token) {
            return null;
        }

        if ($this->tokenChecker instanceof TokenChecker) {
            if (!$this->tokenChecker->checkToken($token)) {
                throw new AccessDeniedException();
            }
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

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return self::TOKEN_TYPE_BEARER;
    }
}
