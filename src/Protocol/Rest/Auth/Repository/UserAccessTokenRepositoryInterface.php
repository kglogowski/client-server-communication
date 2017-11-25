<?php

namespace CSC\Protocol\Rest\Auth\Repository;

use CSC\Model\Interfaces\UserInterface;

/**
 * Interface UserAccessTokenRepositoryInterface
 */
interface UserAccessTokenRepositoryInterface
{
    const
        ALIAS_ACCESS_TOKEN = 'access_token',
        ALIAS_USER = 'user',
        FIELD_USERNAME = 'username',
        FIELD_TOKEN = 'token',
        FIELD_TYPE = 'type'
    ;

    /**
     * @param UserInterface $user
     * @param string|null   $type
     *
     * @return mixed
     */
    public function findOneByUserAndValidDateAndType(UserInterface $user, $type);

    /**
     * @param string $token
     *
     * @return mixed
     */
    public function findOneByTokenAndValidDate(string $token);
}
