<?php

namespace CSC\Protocol\Rest\Auth\Interfaces;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Interface GuardUserAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface GuardUserAware
{
    /**
     * @param AdvancedUserInterface $user
     */
    public function setUser(AdvancedUserInterface $user);
}