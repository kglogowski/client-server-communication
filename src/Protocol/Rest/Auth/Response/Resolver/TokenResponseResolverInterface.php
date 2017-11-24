<?php

namespace CSC\Protocol\Rest\Auth\Response\Resolver;

use CSC\Protocol\Rest\Auth\Model\UserAccessToken;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface TokenResponseResolverInterface
 */
interface TokenResponseResolverInterface
{
    /**
     * @param UserAccessToken $accessToken
     */
    public function setAccessToken(UserAccessToken $accessToken);

    /**
     * @param Response $response
     *
     * @return Response
     */
    public function resolve(Response $response): Response;
}
