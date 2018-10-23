<?php

namespace CSC\Protocol\Rest\Server\Response\Processor;

use CSC\Server\Response\Processor\ServerResponseProcessor;
use FOS\RestBundle\Context\Context;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;

abstract class AbstractRestResponseProcessor implements ServerResponseProcessor
{
    /**
     * @param RestDataObject $dataObject
     *
     * @return Context
     */
    protected function createContext(RestDataObject $dataObject)
    {
        $context = new Context();

        $context->setGroups($dataObject->getSerializationGroups());

        return $context;
    }
}