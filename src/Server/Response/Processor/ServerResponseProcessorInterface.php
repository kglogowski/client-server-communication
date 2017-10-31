<?php

namespace CSC\Server\Response\Processor;

use CSC\Server\DataObject\DataObjectInterface;
use CSC\Server\Response\Model\ServerResponseModelInterface;

/**
 * Interface ServerResponseProcessorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerResponseProcessorInterface
{
    /**
     * @param ServerResponseModelInterface $responseModel
     * @param DataObjectInterface          $dataObject
     *
     * @return mixed
     */
    public function process(ServerResponseModelInterface $responseModel, DataObjectInterface $dataObject);
}