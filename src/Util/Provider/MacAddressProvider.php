<?php

namespace CSC\Component\Auth\Provider;

/**
 * Class MacAddressProvider
 */
class MacAddressProvider
{
    /**
     * @return string
     */
    public static function getMacAddress(): string
    {
        return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : '';
    }
}