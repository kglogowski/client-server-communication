<?php

namespace CSC\Model\Interfaces;

use CSC\Protocol\Rest\Auth\Interfaces\TokenKeyAware;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseInterface;

/**
 * Interface UserInterface
 */
interface UserInterface extends ServerResponseModel, BaseInterface, ExternalAccessibleEntity, AdvancedUserInterface, \Serializable, TokenKeyAware
{
    const
        STATUS_INACTIVE = 'INACTIVE',
        STATUS_BLOCKED = 'BLOCKED',
        STATUS_ACTIVE = 'ACTIVE'
    ;

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
}