<?php

namespace CSC\Model\Traits;

/**
 * Trait UpdateTimestampsTrait
 */
trait UpdateTimestampsTrait
{
    /**
     * Method for doctrine pre-persist and pre-update listener
     * @throws \Exception
     */
    public function updateTimestamps()
    {
        if (method_exists($this, 'setUpdatedAt')) {
            $this->setUpdatedAt(new \DateTimeImmutable('now'));
        }

        if (method_exists($this, 'getCreatedAt') && method_exists($this, 'setCreatedAt')) {
            if (null === $this->getCreatedAt()) {
                $this->setCreatedAt(new \DateTimeImmutable('now'));
            }
        }
    }
}