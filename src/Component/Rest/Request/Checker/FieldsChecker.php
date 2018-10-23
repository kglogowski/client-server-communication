<?php

namespace CSC\Server\Checker;

use CSC\Server\DataObject\SimpleDataObject;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Interface FieldsChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface FieldsChecker
{
    /**
     * @param SimpleDataObject $dataObject
     *
     * @return bool
     *
     * @throws ServerRequestException
     */
    public function check(SimpleDataObject $dataObject): bool;
}