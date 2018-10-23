<?php

namespace CSC\Component\Auth\Security\Encoder;

/**
 * Class Sha512StaticEncoder
 */
class Sha512StaticEncoder
{
    /**
     * @param string $password
     * @param string $salt
     * @param string $pepper
     *
     * @return string
     */
    public static function encode(string $password, string $salt, string $pepper): string
    {
        return hash('sha512', $password . $salt . $pepper);
    }
}
