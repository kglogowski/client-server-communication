<?php

namespace CSC\Component\Rest\Request\Checker;

use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;
use CSC\Exception\ServerRequestException;

/**
 * Interface FieldsChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface FieldsChecker
{
    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return bool
     *
     * @throws ServerRequestException
     */
    public function check(SimpleDataObjectInterface $dataObject): bool;
}