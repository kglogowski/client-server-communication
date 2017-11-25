<?php

namespace CSC\Protocol\Rest\Auth\Security\Resolver;

use CSC\Model\Interfaces\UserInterface;
use CSC\Protocol\Rest\Auth\Model\UserAccessToken;
use CSC\Protocol\Rest\Auth\Security\Generator\JwtUserTokenGenerator;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 *
 * Class UserAccessTokenResolver
 */
class UserAccessTokenResolver implements UserAccessTokenResolverInterface
{
    /**
     * @var TokenGeneratorInterface
     */
    protected $tokenGenerator;

    /**
     * @var int
     */
    protected $tokenLifetime;

    /**
     * UserAccessTokenFactory constructor.
     *
     * @param TokenGeneratorInterface|JwtUserTokenGenerator $tokenGenerator
     * @param array                                         $config
     */
    public function __construct(TokenGeneratorInterface $tokenGenerator, array $config)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenLifetime = (int) $config['token_lifetime'];
    }

    /**
     * @param UserInterface $user
     *
     * @return array
     */
    public function getData(UserInterface $user): array
    {
        return [];
    }

    /**
     * @param UserAccessToken $userAccessToken
     *
     * @return UserAccessToken
     */
    public function resolve(UserAccessToken $userAccessToken): UserAccessToken
    {
        if (false === $userAccessToken->hasToken()) {
            $data = array_merge([
                'username' => $userAccessToken->getUser()->getUsername(),
                'type' => $userAccessToken->getType()
            ], $this->getData($userAccessToken->getUser()));

            $this->tokenGenerator->setData($data);

            $userAccessToken->setToken($this->tokenGenerator->generateToken());
        }

        $lifetimeMod = sprintf('+%d seconds', $this->tokenLifetime);
        $validTo = (new \DateTime())->modify($lifetimeMod);

        $userAccessToken->setValidTo($validTo);

        return $userAccessToken;
    }
}
