<?php

namespace CSC\Server\Request\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface ServerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerRequestProcessor
{
    /**
     * @param DataObject $dataObject
     *
     * @return ServerResponseModel
     */
    public function process(DataObject $dataObject): ServerResponseModel;
}