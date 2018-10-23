<?php

namespace CSC\Component\Auth\Interfaces;

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
