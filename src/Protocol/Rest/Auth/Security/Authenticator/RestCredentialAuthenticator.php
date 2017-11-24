<?php

namespace CSC\Protocol\Rest\Auth\Security\Authenticator;

use CSC\Protocol\Rest\Auth\Model\UserCredentials;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class RestAuthenticator
 */
abstract class RestCredentialAuthenticator extends AbstractUserAuthenticator
{
    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        try {
            /** @var UserCredentials $credentials */
            $credentials = $this->serializer->deserialize($request->getContent(), UserCredentials::class, 'json');
        } catch (\Exception $e) {
            return null;
        }

        if (false === $credentials->isComplete()) {
            return null;
        }

        return [
            'username' => $credentials->getLogin(),
            'password' => $credentials->getPassword(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        return $userProvider->loadUserByUsername($username);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['password'];

        if ($user->getPassword() !== $this->encoder->encodePassword($password, $user->getSalt())) {
            return false;
        }

        return true;
    }
}
