<?php

namespace CSC\Component\Rest\DataObject;

/**
 * Interface SimpleDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface SimpleDataObjectInterface extends DataObject
{
    /**
     * @return string|null
     */
    public function getFields();

    /**
     * @param string|null $fields
     *
     * @return SimpleDataObjectInterface
     */
    public function setFields(string $fields = null): SimpleDataObjectInterface;
}