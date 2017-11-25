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
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $id
     *
     * @return PermissionGroupInterface
     */
    public function setId(string $id): PermissionGroupInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     *
     * @return PermissionGroupInterface
     */
    public function setDescription(string $description): PermissionGroupInterface;

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

    /**
     * @return Collection
     */
    public function getAttributes(): Collection;

    /**
     * @param Collection $attributes
     *
     * @return PermissionGroupInterface
     */
    public function setAttributes(Collection $attributes): PermissionGroupInterface;

    /**
     * @return string
     */
    public function getHref(): string;

    /**
     * @param string $href
     *
     * @return PermissionGroupInterface
     */
    public function setHref(string $href): PermissionGroupInterface;

    /**
     * @return PermissionGroupInterface
     */
    public function getResult(): PermissionGroupInterface;
}