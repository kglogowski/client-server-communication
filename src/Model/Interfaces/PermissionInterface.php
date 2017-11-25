<?php

namespace CSC\Model\Interfaces;

/**
 * Interface PermissionInterface
 */
interface PermissionInterface extends ExternalAccessibleEntity
{
    /**
     * @param string $id
     *
     * @return PermissionInterface
     */
    public function setId(string $id): PermissionInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     *
     * @return PermissionInterface
     */
    public function setDescription(string $description): PermissionInterface;

    /**
     * @return bool
     */
    public function getActive(): bool;

    /**
     * @param boolean $active
     *
     * @return PermissionInterface
     */
    public function setActive(bool $active): PermissionInterface;

    /**
     * @return PermissionGroupInterface
     */
    public function getGroup(): PermissionGroupInterface;

    /**
     * @param PermissionGroupInterface $group
     *
     * @return PermissionInterface
     */
    public function setGroup($group): PermissionInterface;
}