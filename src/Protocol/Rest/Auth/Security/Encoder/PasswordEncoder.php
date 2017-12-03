<?php

namespace CSC\Protocol\Rest\Auth\Security\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;

/**
 * Class PasswordEncoder
 */
class PasswordEncoder extends BasePasswordEncoder
{
    const
        PEPPER = 'UserSaltPepperMix',
        ITERATION = 100
    ;

    /**
     * {@inheritdoc}
     */
    public function encodePassword($password, $salt)
    {
        $iteration = static::ITERATION;

        do {
            $password = Sha512StaticEncoder::encode($password, $salt, static::PEPPER);
        } while (0 < --$iteration);

        return $password;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            return false;
        }

        return true;
    }
}
