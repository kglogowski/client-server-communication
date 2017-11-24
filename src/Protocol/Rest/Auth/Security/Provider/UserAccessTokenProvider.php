<?php

namespace CSC\Protocol\Rest\Auth\Security\Provider;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\Protocol\Rest\Auth\Model\User;
use CSC\Protocol\Rest\Auth\Model\UserAccessToken;
use CSC\Protocol\Rest\Auth\Repository\UserAccessTokenRepositoryInterface;
use CSC\Protocol\Rest\Auth\Security\Authenticator\AbstractUserAuthenticator;
use CSC\Server\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserAccessTokenProvider
 */
class UserAccessTokenProvider
{
    const MESSAGE_NULL_USER = 'No user loaded.';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $tokenType;

    /**
     * UserAccessTokenProvider constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function __construct(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param string|null $tokenType
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @param string $accessTokenClass
     *
     * @return UserAccessToken
     *
     * @throws ServerException
     */
    public function getByClassName(string $accessTokenClass): UserAccessToken
    {
        if (null === $this->user) {
            throw new ServerException(ServerException::ERROR_TYPE_INVALID_PARAMETER, self::MESSAGE_NULL_USER, null, Response::HTTP_UNAUTHORIZED);
        }

        $accessTokenRepository = $this->entityManager->getRepository($accessTokenClass);
        if (!$accessTokenRepository instanceof UserAccessTokenRepositoryInterface) {
            throw new ServerException(ServerException::ERROR_TYPE_INVALID_PARAMETER, AbstractUserAuthenticator::MESSAGE_INVALID_REPOSITORY_CLASS, null, Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = $accessTokenRepository->findOneByUserAndValidDateAndType($this->user, $this->tokenType);
        if (null === $accessToken) {
            $accessToken = new $accessTokenClass;
        }

        return $accessToken->setUser($this->user);
    }
}
