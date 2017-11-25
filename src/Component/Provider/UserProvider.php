<?php

namespace CSC\Component\Provider;

use CSC\Model\Interfaces\UserInterface;
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
     * @return UserInterface
     */
    public function getUser(): UserInterface
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