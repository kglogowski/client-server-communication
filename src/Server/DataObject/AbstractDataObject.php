<?php

namespace CSC\Server\DataObject;

/**
 * Class AbstractDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractDataObject implements DataObject
{
    /**
     * @var bool
     */
    protected $async = false;

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->async;
    }
}