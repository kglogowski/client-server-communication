<?php

namespace CSC\Auth\Security\Authenticator;

use CSC\Model\UserCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class CredentialAuthenticator
 */
abstract class CredentialAuthenticator extends AbstractUserAuthenticator
{
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
