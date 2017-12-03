<?php

namespace CSC\Model;

use CSC\Model\Interfaces\PermissionInterface;
use CSC\Model\Interfaces\RoleInterface;
use CSC\Model\Traits\ResponseModelTrait;
use Doctrine\Common\Collections\Collection;

/**
 * Class Role
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class Role implements RoleInterface
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
     * @param string $id
     *
     * @return RoleInterface
     */
    public function setId(string $id): RoleInterface
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
    public function setDescription(?string $description): RoleInterface
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
    public function addPermission(PermissionInterface $permission): RoleInterface
    {
        $this->permissions->add($permission);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePermission(PermissionInterface $permission): RoleInterface
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
    public function setActive(bool $active): RoleInterface
    {
        $this->active = $active;

        return $this;
    }
}