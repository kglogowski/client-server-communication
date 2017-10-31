<?php

namespace CSC\Server\Request\Processor;

use CSC\Server\DataObject\DataObjectInterface;
use CSC\Server\Response\Model\ServerResponseModelInterface;

/**
 * Interface ServerRequestProcessorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerRequestProcessorInterface
{
    /**
     * @param DataObjectInterface $dataObject
     *
     * @return ServerResponseModelInterface
     */
    public function process(DataObjectInterface $dataObject): ServerResponseModelInterface;
}