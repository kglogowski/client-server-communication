<?php

namespace CSC\Model\Interfaces;

/**
 * Interface LinkToken
 */
interface LinkToken extends ExternalAccessibleEntity
{
    const
        STATUS_ACTIVE = 'ACTIVE',
        STATUS_USED = 'USED',
        STATUS_EXPIRED = 'EXPIRED'
    ;

    const INDEX_SEARCH_TOKEN = 'hash';

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return LinkToken
     */
    public function setUser(UserInterface $user): LinkToken;

    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @param string $token
     *
     * @return LinkToken
     */
    public function setToken(string $token): LinkToken;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     *
     * @return LinkToken
     */
    public function setType(string $type): LinkToken;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     *
     * @return LinkToken
     */
    public function setStatus(string $status): LinkToken;
}