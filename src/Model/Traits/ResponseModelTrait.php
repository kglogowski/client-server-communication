<?php

namespace CSC\Model\Traits;

/**
 * Trait ResponseModelTrait
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
trait ResponseModelTrait
{
    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this;
    }
}