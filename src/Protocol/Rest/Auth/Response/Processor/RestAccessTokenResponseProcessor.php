<?php

namespace CSC\Protocol\Rest\Auth\Response\Processor;

use CSC\Protocol\Rest\Auth\Model\UserAccessToken;
use CSC\Protocol\Rest\Auth\Response\Resolver\TokenResponseResolverInterface;
use CSC\Protocol\Rest\Auth\Security\Authenticator\AbstractUserAuthenticator;
use CSC\Server\Exception\ServerException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestAccessTokenResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestAccessTokenResponseProcessor
{
    /**
     * @var TokenResponseResolverInterface
     */
    protected $restResponseResolver;

    /**
     * @var TokenResponseResolverInterface
     */
    protected $ssoResponseResolver;

    /**
     * RestAccessTokenResponseProcessor constructor.
     *
     * @param TokenResponseResolverInterface $restResponseResolver
     * @param TokenResponseResolverInterface $ssoResponseResolver
     */
    public function __construct(TokenResponseResolverInterface $restResponseResolver, TokenResponseResolverInterface $ssoResponseResolver)
    {
        $this->restResponseResolver = $restResponseResolver;
        $this->ssoResponseResolver = $ssoResponseResolver;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @throws ServerException
     */
    public function process(Request $request): Response
    {
        try {
            $accessToken = $request->request->get(AbstractUserAuthenticator::ACCESS_TOKEN_REQUEST_KEY);
        } catch (\Exception $e) {
            throw $this->getAccessDeniedException();
        }

        $request->request->remove(AbstractUserAuthenticator::ACCESS_TOKEN_REQUEST_KEY);
        if (!$accessToken instanceof UserAccessToken) {
            throw $this->getAccessDeniedException();
        }

        $response = new JsonResponse();

        // Set content
        $this->restResponseResolver->setAccessToken($accessToken);
        $this->restResponseResolver->resolve($response);

        // Set sso cookie
        $this->ssoResponseResolver->setAccessToken($accessToken);
        $response = $this->ssoResponseResolver->resolve($response);

        return $response->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @return ServerException
     *
     * @throws ServerException
     */
    protected function getAccessDeniedException(): ServerException
    {
        return new ServerException(
            ServerException::ERROR_TYPE_AUTHORIZATION_FAILED,
            AbstractUserAuthenticator::MESSAGE_ACCESS_FORBIDDEN,
            null,
            Response::HTTP_FORBIDDEN
        );
    }
}