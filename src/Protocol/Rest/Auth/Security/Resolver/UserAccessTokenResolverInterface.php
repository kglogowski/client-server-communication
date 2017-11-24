<?php

namespace CSC\Protocol\Rest\Auth\Security\Resolver;

use CSC\Protocol\Rest\Auth\Model\UserAccessToken;

/**
 * Interface UserAccessTokenResolverInterface
 */
interface UserAccessTokenResolverInterface
{
    /**
     * @param UserAccessToken $userAccessToken
     *
     * @return UserAccessToken
     */
    public function resolve(UserAccessToken $userAccessToken): UserAccessToken;
}