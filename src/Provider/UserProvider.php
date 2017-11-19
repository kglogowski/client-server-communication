<?php

namespace CSC\Provider;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserProvider
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * UserProvider constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * TODO USER_MODEL
     * @return mixed|null
     */
    public function getUser()
    {
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}