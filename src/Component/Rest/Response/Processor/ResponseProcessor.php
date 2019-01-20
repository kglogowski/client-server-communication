<?php

namespace CSC\Server\Response\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Component\Rest\Response\Model\ServerResponseModel;
use FOS\RestBundle\View\View;

/**
 * Interface ResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ResponseProcessor
{
    /**
     * @param DataObject $dataObject
     *
     * @return View
     */
    public function process(DataObject $dataObject): View;
}