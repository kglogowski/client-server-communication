<?php

namespace CSC\Protocol\Rest\Auth\Response\Resolver;

use CSC\Component\Decorator\DateTime\DateTimeDecoratorInterface;
use CSC\Model\UserAccessToken;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestTokenResponseResolver
 */
class RestTokenResponseResolver implements TokenResponseResolverInterface
{
    /**
     * @var UserAccessToken
     */
    protected $accessToken;

    /**
     * @var DateTimeDecoratorInterface
     */
    protected $dateTimeDecorator;

    /**
     * RestTokenResponseResolver constructor.
     *
     * @param DateTimeDecoratorInterface $dateTimeDecorator
     */
    public function __construct(DateTimeDecoratorInterface $dateTimeDecorator)
    {
        $this->dateTimeDecorator = $dateTimeDecorator;
    }

    /**
     * {@inheritdoc}
     */
    public function setAccessToken(UserAccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Response $response): Response
    {
        if (null === $this->accessToken) {
            return $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        $body = new \stdClass();

        // @codingStandardsIgnoreStart
        $body->token = $this->accessToken->getToken();
        $body->valid_to = $this->dateTimeDecorator->format($this->accessToken->getValidTo());
        // @codingStandardsIgnoreEnd

        $response->setContent(json_encode($body));

        return $response->setStatusCode(Response::HTTP_OK);
    }
}
