<?php

namespace CSC\Server\Response\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface ServerResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerResponseProcessor
{
    /**
     * @param ServerResponseModel $responseModel
     * @param DataObject          $dataObject
     *
     * @return mixed
     */
    public function process(ServerResponseModel $responseModel, DataObject $dataObject);
}