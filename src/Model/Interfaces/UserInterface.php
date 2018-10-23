<?php

namespace CSC\Model\Interfaces;

use CSC\Model\UserAccessToken;
use CSC\Component\Auth\Interfaces\TokenKeyAware;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface as BaseInterface;

/**
 * Interface UserInterface
 */
interface UserInterface extends ServerResponseModel, BaseInterface, ExternalAccessibleEntity, \Serializable, TokenKeyAware
{
    const
        STATUS_INACTIVE = 'INACTIVE',
        STATUS_BLOCKED = 'BLOCKED',
        STATUS_ACTIVE = 'ACTIVE'
    ;

    /**
     * @return bool
     */
    public function hasId(): bool;

    /**
     * @param int $id
     *
     * @return UserInterface
     */
    public function setId(int $id): UserInterface;

    /**
     * @return string
     */
    public function getLogin(): string;

    /**
     * @param string $login
     *
     * @return UserInterface
     */
    public function setLogin(string $login): UserInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail(string $email): UserInterface;

    /**
     * @param Collection $roles
     *
     * @return UserInterface
     */
    public function setRoles(Collection $roles): UserInterface;

    /**
     * @param RoleInterface $role
     *
     * @return UserInterface
     */
    public function addRole(RoleInterface $role): UserInterface;

    /**
     * @param RoleInterface $role
     *
     * @return UserInterface
     */
    public function removeRole(RoleInterface $role): UserInterface;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string|null $status
     *
     * @return UserInterface
     */
    public function setStatus(?string $status): UserInterface;

    /**
     * @return LinkToken[]|Collection
     */
    public function getLinkTokens(): Collection;

    /**
     * @param LinkToken[]|Collection $linkTokens
     *
     * @return UserInterface
     */
    public function setLinkTokens(Collection $linkTokens): UserInterface;

    /**
     * @param LinkToken $linkToken
     *
     * @return UserInterface
     */
    public function addLinkToken(LinkToken $linkToken): UserInterface;

    /**
     * @param LinkToken $linkToken
     *
     * @return UserInterface
     */
    public function removeLinkToken(LinkToken $linkToken): UserInterface;

    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array;

    /**
     * @return Collection|RoleInterface[]
     */
    public function getRolesAsCollection(): Collection;

    /**
     * @return string|null
     */
    public function getPlainPassword();

    /**
     * @param string $password
     *
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface;

    /**
     * @param string|null $plainPassword
     *
     * @return UserInterface
     */
    public function setPlainPassword($plainPassword): UserInterface;

    /**
     * @param string $salt
     *
     * @return UserInterface
     */
    public function setSalt(string $salt): UserInterface;

    /**
     * @return null
     */
    public function getNullPassword();

    /**
     * @return string
     */
    public function regenerateSalt(): string;

    /**
     * @return UserAccessToken
     */
    public function getAccessToken(): UserAccessToken;

    /**
     * @return bool
     */
    public function hasAccessToken(): bool;

    /**
     * @param UserAccessToken|object $accessToken
     *
     * @return UserInterface
     */
    public function setAccessToken($accessToken): UserInterface;
}