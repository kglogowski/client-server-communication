<?php

namespace CSC\Model\Interfaces;

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
