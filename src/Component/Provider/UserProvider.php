<?php

namespace CSC\Component\Provider;

use CSC\Protocol\Rest\Auth\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class UserProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
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
     * @return User
     */
    public function getUser(): User
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