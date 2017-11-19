<?php

namespace CSC\ORM;

/**
 * Interface GuardUserAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface GuardUserAware
{
    /**
     * TODO USER_MODEL
     * @param mixed $user
     */
    public function setUser($user);
}