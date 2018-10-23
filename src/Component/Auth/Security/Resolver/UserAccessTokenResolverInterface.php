<?php

namespace CSC\Component\Auth\Security\Resolver;

use CSC\Model\UserAccessToken;

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