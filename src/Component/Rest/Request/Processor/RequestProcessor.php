<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\PagerDataObjectInterface;
use CSC\Server\DataObject\SimpleDataObjectInterface;

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