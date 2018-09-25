<?php

namespace CSC\Auth\Security\Checker;

/**
 * Interface TokenChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface TokenChecker
{
    /**
     * @param string $token
     *
     * @return bool
     */
    public function checkToken(string $token): bool;
}