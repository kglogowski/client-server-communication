<?php

namespace CSC\Server\Checker;

use CSC\Server\DataObject\SimpleDataObjectInterface;
use CSC\Server\Request\Exception\ServerRequestException;

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