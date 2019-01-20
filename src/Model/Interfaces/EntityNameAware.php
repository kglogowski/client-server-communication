<?php

namespace CSC\Model\Interfaces;

/**
 * Interface EntityNameAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface EntityNameAware
{
    /**
     * @return string|null
     */
    public function getEntityName(): ?string;
}