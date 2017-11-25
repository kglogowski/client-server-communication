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
     * @return string|null A string representation of the role, or null
     */
    public function getRole();

    /**
     * @param string $id
     *
     * @return RoleInterface
     */
    public function setId(string $id): RoleInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     *
     * @return RoleInterface
     */
    public function setDescription(string $description): RoleInterface;

    /**
     * @return array
     */
    public function getAttributeIds(): array;

    /**
     * @param array $attributeIds
     *
     * @return RoleInterface
     */
    public function setAttributeIds(array $attributeIds): RoleInterface;

    /**
     * @return PermissionInterface[]|Collection
     */
    public function getAttributes(): Collection;

    /**
     * @param PermissionInterface[]|Collection $attributes
     *
     * @return RoleInterface
     */
    public function setAttributes(Collection $attributes): RoleInterface;

    /**
     * @return array
     */
    public function getPermissions(): array;

    /**
     * @param PermissionInterface $attribute
     *
     * @return RoleInterface
     */
    public function addAttribute(PermissionInterface $attribute): RoleInterface;

    /**
     * @param PermissionInterface $attribute
     *
     * @return RoleInterface
     */
    public function removeAttribute(PermissionInterface $attribute): RoleInterface;

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

    /**
     * @return bool
     */
    public function isMigration(): bool;

    /**
     * @return bool
     */
    public function getMigration(): bool;

    /**
     * @param bool $migration
     *
     * @return RoleInterface
     */
    public function setMigration(bool $migration): RoleInterface;
}