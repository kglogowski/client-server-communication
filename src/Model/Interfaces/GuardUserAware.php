<?php

namespace CSC\Model\Interfaces;

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