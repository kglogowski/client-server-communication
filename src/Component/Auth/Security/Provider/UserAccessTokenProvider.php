<?php

namespace CSC\Auth\Security\Provider;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\Model\Interfaces\UserInterface;
use CSC\Model\UserAccessToken;
use CSC\Auth\Repository\UserAccessTokenRepositoryInterface;
use CSC\Auth\Security\Authenticator\AbstractUserAuthenticator;
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
     * @var UserInterface
     */
    protected $user;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

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
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
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
            throw new ServerException(
                ServerException::ERROR_TYPE_INVALID_PARAMETER,
                AbstractUserAuthenticator::MESSAGE_INVALID_REPOSITORY_CLASS,
                null,
                Response::HTTP_UNAUTHORIZED
            );
        }

        $accessToken = $accessTokenRepository->findOneByUserAndValidDate($this->user);
        if (null === $accessToken) {
            $accessToken = new $accessTokenClass;
        }

        return $accessToken->setUser($this->user);
    }
}
