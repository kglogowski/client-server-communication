<?php

namespace CSC\Server\DataObject;

/**
 * Interface DataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface DataObject
{
    /**
     * To check is async response
     *
     * @return bool
     */
    public function isAsync(): bool;

    /**
     * @param bool $async
     *
     * @return DataObject
     */
    public function setAsync(bool $async): DataObject;
}