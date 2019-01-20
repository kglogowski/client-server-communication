<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;

/**
 * Interface RequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RequestProcessor
{
    /**
     * @param DataObject|SimpleDataObjectInterface|PagerDataObjectInterface $dataObject
     *
     * @return DataObject
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject;
}