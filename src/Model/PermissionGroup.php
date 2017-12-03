<?php

namespace CSC\Model;

use CSC\Model\Interfaces\PermissionGroupInterface;
use CSC\Model\Interfaces\PermissionInterface;
use CSC\Model\Traits\ResponseModelTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class PermissionGroup
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class PermissionGroup implements PermissionGroupInterface
{
    use ResponseModelTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var Collection
     */
    protected $permissions;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId(string $id): PermissionGroupInterface
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(?string $description): PermissionGroupInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function addPermission(PermissionInterface $permission): PermissionGroupInterface
    {
        $this->permissions->add($permission);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePermission(PermissionInterface $permission): PermissionGroupInterface
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * {@inheritdoc}
     */
    public function setActive(bool $active): PermissionGroupInterface
    {
        $this->active = $active;

        return $this;
    }
}