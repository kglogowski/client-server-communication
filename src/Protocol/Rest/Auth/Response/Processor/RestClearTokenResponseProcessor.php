<?php

namespace CSC\Protocol\Rest\Auth\Response\Processor;

use CSC\Component\Provider\EntityManagerProvider;
use CSC\Protocol\Rest\Auth\Response\Resolver\TokenResponseResolverInterface;
use CSC\Protocol\Rest\Auth\Security\Authenticator\AbstractUserAuthenticator;
use CSC\Server\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use CSC\Protocol\Rest\Auth\Model\User as BaseUser;

/**
 * Class RestClearTokenResponseProcessor
 */
class RestClearTokenResponseProcessor
{
    /**
     * @var TokenResponseResolverInterface
     */
    protected $ssoResponseResolver;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * RestClearTokenResponseProcessor constructor.
     *
     * @param TokenResponseResolverInterface $ssoResponseResolver
     * @param TokenStorageInterface          $tokenStorage
     * @param EntityManagerProvider          $entityManagerProvider
     */
    public function __construct(
        TokenResponseResolverInterface $ssoResponseResolver,
        TokenStorageInterface $tokenStorage,
        EntityManagerProvider $entityManagerProvider
    )
    {
        $this->ssoResponseResolver = $ssoResponseResolver;
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
            throw new ServerException(ServerException::ERROR_TYPE_INVALID_PARAMETER, 'Not supported type of user', null, Response::HTTP_BAD_REQUEST);
        }

        $accessToken = $this->user->getAccessToken();

        try {
            $this->entityManager->remove($accessToken);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new ServerException(ServerException::ERROR_SYSTEM_ERROR, 'Unable to clear token', null, Response::HTTP_BAD_REQUEST);
        }

        $response = new Response();

        // Remove sso cookie
        $this->ssoResponseResolver->setAccessToken($accessToken);
        $response = $this->ssoResponseResolver->resolve($response);

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
