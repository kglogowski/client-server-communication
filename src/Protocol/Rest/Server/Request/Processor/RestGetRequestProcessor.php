<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
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
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestGetRequestProcessor constructor.
     *
     * @param RestGetElementProvider   $elementProvider
     * @param RestResponseModelFactory $responseModelFactory
     */
    public function __construct(RestGetElementProvider $elementProvider, RestResponseModelFactory $responseModelFactory)
    {
        $this->elementProvider = $elementProvider;
        $this->responseModelFactory = $responseModelFactory;
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

        $this->checkVoters($dataObject->getVoters(), $object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));

        return $dataObject;
    }
}