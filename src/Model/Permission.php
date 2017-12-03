<?php

namespace CSC\Model;

use CSC\Model\Interfaces\PermissionGroupInterface;
use CSC\Model\Interfaces\PermissionInterface;
use CSC\Model\Traits\ResponseModelTrait;

/**
 * Class Permission
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class Permission implements PermissionInterface
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
     * @var boolean
     */
    protected $active;

    /**
     * @var PermissionGroupInterface
     */
    protected $group;

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
    public function setId(string $id): PermissionInterface
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
    public function setDescription(?string $description): PermissionInterface
    {
        $this->description = $description;

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
    public function setActive(bool $active): PermissionInterface
    {
        $this->active = $active;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroup(): PermissionGroupInterface
    {
        return $this->group;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroup(PermissionGroupInterface $group): PermissionInterface
    {
        $this->group = $group;

        return $this;
    }
}