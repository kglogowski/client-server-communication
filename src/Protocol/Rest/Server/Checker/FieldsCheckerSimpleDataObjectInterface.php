<?php

namespace CSC\Protocol\Rest\Server\Checker;

use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Interface FieldsCheckerSimpleDataObjectInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface FieldsCheckerSimpleDataObjectInterface
{
    /**
     * @param RestSimpleDataObject $dataObject
     *
     * @return bool
     *
     * @throws ServerRequestException
     */
    public function check(RestSimpleDataObject $dataObject): bool;
}