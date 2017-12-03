<?php

namespace CSC\Model\Interfaces;

use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Collections\Collection;

/**
 * Interface PermissionGroupInterface
 */
interface PermissionGroupInterface extends ServerResponseModel, ExternalAccessibleEntity
{
    /**
     * @param string $id
     *
     * @return PermissionGroupInterface
     */
    public function setId(string $id): PermissionGroupInterface;

    /**
     * @return string
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     *
     * @return PermissionGroupInterface
     */
    public function setDescription(?string $description): PermissionGroupInterface;

    /**
     * @return Collection
     */
    public function getPermissions(): Collection;

    /**
     * @param PermissionInterface $permission
     *
     * @return PermissionGroupInterface
     */
    public function addPermission(PermissionInterface $permission): PermissionGroupInterface;

    /**
     * @param PermissionInterface $permission
     *
     * @return PermissionGroupInterface
     */
    public function removePermission(PermissionInterface $permission): PermissionGroupInterface;

    /**
     * @return bool
     */
    public function getActive(): bool;

    /**
     * @param boolean $active
     *
     * @return PermissionGroupInterface
     */
    public function setActive(bool $active): PermissionGroupInterface;
}