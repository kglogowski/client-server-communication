<?php

namespace CSC\Protocol\Rest\Auth\Interfaces;

use CSC\Model\Interfaces\UserInterface;

/**
 * Interface GuardUserAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface GuardUserAware
{
    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);
}