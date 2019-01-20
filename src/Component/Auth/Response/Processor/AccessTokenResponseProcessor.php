<?php

namespace CSC\Component\Auth\Response\Processor;

use CSC\Exception\ServerException;
use CSC\Model\UserAccessToken;
use CSC\Component\Auth\Response\Resolver\TokenResponseResolverInterface;
use CSC\Component\Auth\Security\Authenticator\AbstractUserAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AccessTokenResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class AccessTokenResponseProcessor
{
    /**
     * @var TokenResponseResolverInterface
     */
    protected $responseResolver;

    /**
     * AccessTokenResponseProcessor constructor.
     *
     * @param TokenResponseResolverInterface $responseResolver
     */
    public function __construct(TokenResponseResolverInterface $responseResolver)
    {
        $this->responseResolver = $responseResolver;
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
        $this->responseResolver->setAccessToken($accessToken);
        $this->responseResolver->resolve($response);

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