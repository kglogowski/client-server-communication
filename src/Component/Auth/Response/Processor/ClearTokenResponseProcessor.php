<?php

namespace CSC\Auth\Response\Processor;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\Component\Translate\TranslateDictionary;
use CSC\Model\Interfaces\UserInterface;
use CSC\Auth\Security\Authenticator\AbstractUserAuthenticator;
use CSC\Server\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use CSC\Model\User as BaseUser;

/**
 * Class ClearTokenResponseProcessor
 */
class ClearTokenResponseProcessor
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ClearTokenResponseProcessor constructor.
     *
     * @param TokenStorageInterface          $tokenStorage
     * @param EntityManagerProvider          $entityManagerProvider
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        EntityManagerProvider $entityManagerProvider
    )
    {
        $this->user = $tokenStorage->getToken()->getUser();
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @return Response
     *
     * @throws ServerException
     */
    public function process(): Response
    {
        if (!$this->user instanceof BaseUser) {
            throw new ServerException(
                ServerException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_NOT_SUPPORTED_TYPE_OF_USER,
                null,
                Response::HTTP_BAD_REQUEST);
        }

        $accessToken = $this->user->getAccessToken();

        try {
            $this->entityManager->remove($accessToken);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new ServerException(
                ServerException::ERROR_SYSTEM_ERROR,
                TranslateDictionary::KEY_UNABLE_CLEAR_TOKEN,
                null,
                Response::HTTP_BAD_REQUEST
            );
        }

        $response = new Response();

        return $response->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    /**
     * @return ServerException
     *
     * @throws ServerException
     */
    protected function getAccessDeniedException(): ServerException
    {
        return new ServerException(ServerException::ERROR_TYPE_AUTHORIZATION_FAILED, AbstractUserAuthenticator::MESSAGE_ACCESS_FORBIDDEN, null, Response::HTTP_FORBIDDEN);
    }
}
