<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class RestGetRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestGetRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var RestGetElementProvider
     */
    protected $elementProvider;

    /**
     * GetRequestProcessor constructor.
     *
     * @param RestGetElementProvider $elementProvider
     */
    public function __construct(RestGetElementProvider $elementProvider)
    {
        $this->elementProvider = $elementProvider;
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return RestDataObject
     * @throws \Exception
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {
        $object = $this->elementProvider->getElement($dataObject);

        if (!$object instanceof ServerResponseModel) {
            throw new \Exception(sprintf('Entity "%s" must implement ServerResponseModel', get_class($object)));
        }

        $dataObject->setResponseModel($object);

        return $dataObject;
    }
}