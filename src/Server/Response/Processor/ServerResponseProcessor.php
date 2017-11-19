<?php

namespace CSC\Server\Response\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Response\Model\ServerResponseModel;
use FOS\RestBundle\View\View;

/**
 * Interface ServerResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerResponseProcessor
{
    /**
     * @param DataObject $dataObject
     *
     * @return View
     */
    public function process(DataObject $dataObject): View;
}