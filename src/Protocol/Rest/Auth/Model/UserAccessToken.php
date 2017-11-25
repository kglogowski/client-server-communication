<?php

namespace CSC\Protocol\Rest\Auth\Model;

use CSC\Model\Interfaces\UserInterface;
use CSC\Model\Traits\CreatedAtTrait;
use CSC\Model\Traits\UpdatedAtTrait;
use CSC\Model\Traits\UpdateTimestampsTrait;

/**
 * Class UserAccessToken
 */
abstract class UserAccessToken
{
    use CreatedAtTrait;
    use UpdatedAtTrait;
    use UpdateTimestampsTrait;

    protected static $availableStatuses = [];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var \DateTimeInterface
     */
    protected $validTo;

    /**
     * @var string
     */
    protected $providerKey;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     *
     * @return UserAccessToken
     */
    public function setUser(UserInterface $user): UserAccessToken
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function hasToken(): bool
    {
        return null !== $this->token;
    }

    /**
     * @param string $token
     *
     * @return UserAccessToken
     */
    public function setToken(string $token): UserAccessToken
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getValidTo(): \DateTimeInterface
    {
        return $this->validTo;
    }

    /**
     * @param \DateTimeInterface $validTo
     *
     * @return UserAccessToken
     */
    public function setValidTo(\DateTimeInterface $validTo): UserAccessToken
    {
        $this->validTo = $validTo;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        $now = new \DateTime();

        return $this->validTo > $now;
    }

    /**
     * @return string|null
     */
    public function getProviderKey()
    {
        return $this->providerKey;
    }

    /**
     * @param string|null $providerKey
     *
     * @return UserAccessToken
     */
    public function setProviderKey($providerKey): UserAccessToken
    {
        $this->providerKey = $providerKey;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * @param string $type
     *
     * @return UserAccessToken
     */
    public function setType(string $type): UserAccessToken
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $type
     * @return bool
     */
    public static function wrongType($type): bool
    {
        return !in_array($type, static::$availableStatuses, true);
    }
}
