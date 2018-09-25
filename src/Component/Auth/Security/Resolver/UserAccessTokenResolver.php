<?php

namespace CSC\Auth\Security\Resolver;

use CSC\DependencyInjection\Configuration;
use CSC\Model\Interfaces\UserInterface;
use CSC\Model\UserAccessToken;
use CSC\Auth\Security\Generator\JwtUserTokenGenerator;
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
        $this->tokenLifetime = (int) $config[Configuration::INDEX_TOKEN_LIFETIME];
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
            $data = $this->getData($userAccessToken->getUser());
            $data['username'] = $userAccessToken->getUser()->getUsername();

            $this->tokenGenerator->setData($data);

            $userAccessToken->setToken($this->tokenGenerator->generateToken());
        }

        $lifetimeMod = sprintf('+%d seconds', $this->tokenLifetime);
        $validTo = (new \DateTime())->modify($lifetimeMod);

        $userAccessToken->setValidTo($validTo);

        return $userAccessToken;
    }
}
