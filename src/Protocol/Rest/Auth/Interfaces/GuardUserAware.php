<?php

namespace CSC\Protocol\Rest\Auth\Interfaces;

use CSC\Protocol\Rest\Auth\Model\User;

/**
 * Interface GuardUserAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface GuardUserAware
{
    /**
     * @param User $user
     */
    public function setUser(User $user);
}