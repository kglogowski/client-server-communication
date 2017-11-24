<?php

namespace CSC\Component\ORM;

/**
 * Interface EntityNameAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface EntityNameAware
{
    /**
     * @return string
     */
    public function getEntityName(): string;
}