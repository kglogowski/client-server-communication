<?php

namespace CSC\Model\Interfaces;

use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Collections\Collection;

/**
 * Interface RoleInterface
 */
interface RoleInterface extends ServerResponseModel, ExternalAccessibleEntity
{
    /**
     * @param string $id
     *
     * @return RoleInterface
     */
    public function setId(string $id): RoleInterface;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @param null|string $description
     *
     * @return RoleInterface
     */
    public function setDescription(?string $description): RoleInterface;

    /**
     * @param PermissionInterface $permission
     *
     * @return RoleInterface
     */
    public function addPermission(PermissionInterface $permission): RoleInterface;

    /**
     * @param PermissionInterface $permission
     *
     * @return RoleInterface
     */
    public function removePermission(PermissionInterface $permission): RoleInterface;

    /**
     * @return Collection|PermissionInterface[]
     */
    public function getPermissions(): Collection;

    /**
     * @return bool
     */
    public function getActive(): bool;

    /**
     * @param bool $active
     *
     * @return RoleInterface
     */
    public function setActive(bool $active): RoleInterface;
}