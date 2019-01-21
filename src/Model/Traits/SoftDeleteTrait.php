<?php

namespace CSC\Model\Traits;

/**
 * Trait SoftDeleteTrait
 */
trait SoftDeleteTrait
{
    /**
     * @var bool
     */
    protected $isDeleted = false;

    /**
     * @return $this
     */
    public function delete()
    {
        $this->isDeleted = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function revert()
    {
        $this->isDeleted = false;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return !$this->isDeleted;
    }
}