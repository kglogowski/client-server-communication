<?php

namespace CSC\Protocol\Rest\Auth\Interfaces;

/**
 * Interface TokenKeyAware
 */
interface TokenKeyAware
{
    /**
     * @return string
     */
    public function getTokenKey(): string;
}
