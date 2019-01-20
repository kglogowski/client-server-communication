<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface RequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RequestProcessor
{
    /**
     * @param DataObject $dataObject
     *
     * @return DataObject
     */
    public function process(DataObject $dataObject): DataObject;
}