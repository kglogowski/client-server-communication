<?php

namespace CSC\Model;

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