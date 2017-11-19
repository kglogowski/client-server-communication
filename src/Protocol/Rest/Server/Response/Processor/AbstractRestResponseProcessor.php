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

        $supportedSerializationGroups = $dataObject->getSupportedSerializationGroups();

        $intersectSerializationGroups = array_intersect($dataObject->getSerializationGroups(), $supportedSerializationGroups);

        if (count($dataObject->getSerializationGroups()) !== count($intersectSerializationGroups)) {
            throw new \InvalidArgumentException('Model contains not supported serialization groups');
        }

        $context->setGroups($intersectSerializationGroups);

        return $context;
    }
}