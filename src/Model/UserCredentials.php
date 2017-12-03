<?php

namespace CSC\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class UserCredentials
 */
class UserCredentials
{
    /**
     * Nazwa użytkownika
     *
     * @var string
     *
     * @JMS\Type("string")
     */
    protected $login;

    /**
     * Hasło
     *
     * @var string
     *
     * @JMS\Type("string")
     */
    protected $password;

    /**
     * @return string|null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return UserCredentials
     */
    public function setLogin(string $login): UserCredentials
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return UserCredentials
     */
    public function setPassword(string $password): UserCredentials
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return null !== $this->login && null !== $this->password;
    }
}
