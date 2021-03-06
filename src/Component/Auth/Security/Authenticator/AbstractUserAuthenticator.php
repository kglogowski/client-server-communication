<?php

namespace CSC\Component\Auth\Security\Authenticator;

use CSC\Component\Doctrine\Provider\EntityManagerProvider;
use CSC\Component\Auth\Security\Checker\TokenChecker;
use CSC\Component\Auth\Security\Provider\UserAccessTokenProvider;
use CSC\Component\Auth\Security\Resolver\UserAccessTokenResolverInterface;
use CSC\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use CSC\Model\User as BaseUser;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * Class AbstractUserAuthenticator
 */
abstract class AbstractUserAuthenticator extends AbstractGuardAuthenticator implements LoggerAwareInterface
{
    const
        MESSAGE_AUTH_REQUIRED = 'Authentication Required',
        MESSAGE_ACCESS_FORBIDDEN = 'Access Forbidden',
        MESSAGE_INVALID_REPOSITORY_CLASS = 'Invalid token repository class given'
    ;

    const ACCESS_TOKEN_REQUEST_KEY = 'csc_user_access_token_key';

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var PasswordEncoderInterface
     */
    protected $encoder;

    /**
     * @var UserAccessTokenProvider
     */
    protected $tokenProvider;

    /**
     * @var UserAccessTokenResolverInterface
     */
    protected $tokenResolver;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var TokenChecker
     */
    protected $tokenChecker;

    /**
     * AbstractUserAuthenticator constructor.
     *
     * @param SerializerInterface              $serializer
     * @param PasswordEncoderInterface         $encoder
     * @param UserAccessTokenProvider          $tokenProvider
     * @param UserAccessTokenResolverInterface $tokenResolver
     * @param EntityManagerProvider            $entityManagerProvider
     * @param TokenStorageInterface            $tokenStorage
     */
    public function __construct(
        SerializerInterface $serializer,
        PasswordEncoderInterface $encoder,
        UserAccessTokenProvider $tokenProvider,
        UserAccessTokenResolverInterface $tokenResolver,
        EntityManagerProvider $entityManagerProvider,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->serializer = $serializer;
        $this->encoder = $encoder;
        $this->tokenProvider = $tokenProvider;
        $this->tokenResolver = $tokenResolver;
        $this->entityManager = $entityManagerProvider->getEntityManager();
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return string
     */
    abstract public function getAccessTokenClass(): string;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /** @var BaseUser $user */
        $user = $token->getUser();
        $tokenType = $request->headers->get(TokenAuthenticator::TYPE_HEADER_NAME);

        $this->tokenProvider->setUser($user);

        $accessToken = $this->tokenProvider->getByClassName($this->getAccessTokenClass());
        $accessToken = $this->tokenResolver->resolve($accessToken);

        $accessToken->setProviderKey($user->getTokenKey());

        $this->entityManager->persist($accessToken);
        $this->entityManager->getUnitOfWork()->commit($accessToken);

        $user->setAccessToken($accessToken);
        $request->request->add([static::ACCESS_TOKEN_REQUEST_KEY => $accessToken]);
        $this->logger->debug(sprintf('User "%s" authenticate successfully using "%s"', $user->getUsername(), $this->getAccessTokenClass()));

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        $error = new \stdClass();

        $error->error = ServerException::ERROR_TYPE_AUTHORIZATION_FAILED;
        $error->description = $message;
        $error->status = Response::HTTP_FORBIDDEN;
        $content = json_encode($error);

        $error->accessToken = $this->getAccessTokenClass();
        $this->logger->debug(json_encode($error));

        return (new JsonResponse())
            ->setContent($content)
            ->setStatusCode(Response::HTTP_FORBIDDEN)
        ;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new ServerException(ServerException::ERROR_TYPE_AUTHORIZATION_FAILED, static::MESSAGE_AUTH_REQUIRED, null, Response::HTTP_UNAUTHORIZED, $authException);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function isAlreadyAuthenticated(): bool
    {
        $token = $this->tokenStorage->getToken();

        return $token && $token->isAuthenticated();
    }

    /**
     * @param TokenChecker $checker
     */
    public function setTokenChecker(TokenChecker $checker)
    {
        $this->tokenChecker = $checker;
    }
}
