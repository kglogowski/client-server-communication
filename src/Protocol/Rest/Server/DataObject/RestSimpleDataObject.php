<?php

namespace CSC\Protocol\Rest\Server\DataObject;

/**
 * Interface RestSimpleDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestSimpleDataObject extends RestDataObject
{
    /**
     * @return string|null
     */
    public function getFields();

    /**
     * @param string|null $fields
     *
     * @return RestSimpleDataObject
     */
    public function setFields(string $fields = null): RestSimpleDataObject;
}