<?php

namespace CSC\Auth\Response\Resolver;

use CSC\Component\Decorator\DateTime\DateTimeDecoratorInterface;
use CSC\Model\UserAccessToken;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TokenResponseResolver
 */
class TokenResponseResolver implements TokenResponseResolverInterface
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
     * TokenResponseResolver constructor.
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

        // @codingStandardsIgnoart
        $body->token = $this->accessToken->getToken();
        $body->valid_to = $this->dateTimeDecorator->format($this->accessToken->getValidTo());
        // @codingStandardsIgnoreEnd

        $response->setContent(json_encode($body));

        return $response->setStatusCode(Response::HTTP_OK);
    }
}
