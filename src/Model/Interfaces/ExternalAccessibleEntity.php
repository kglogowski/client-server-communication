<?php

namespace CSC\Model\Interfaces;

/**
 * Interface ExternalAccessibleEntity
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ExternalAccessibleEntity
{
    /**
     * @return string|int|null
     */
    public function getId();
}