<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Component\Executor\DeleteExecutor;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Provider\RestGetElementProvider;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Server\Response\Model\BasicServerResponseModel;

/**
 * Class RestDeleteRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDeleteRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var RestGetElementProvider
     */
    protected $elementProvider;

    /**
     * @var DeleteExecutor
     */
    protected $deleteExecutor;

    /**
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestDeleteRequestProcessor constructor.
     *
     * @param RestGetElementProvider   $elementProvider
     * @param DeleteExecutor           $deleteExecutor
     * @param RestResponseModelFactory $responseModelFactory
     */
    public function __construct(
        RestGetElementProvider $elementProvider,
        DeleteExecutor $deleteExecutor,
        RestResponseModelFactory $responseModelFactory
    )
    {
        $this->elementProvider = $elementProvider;
        $this->deleteExecutor = $deleteExecutor;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param RestDataObject|RestSimpleDataObject $dataObject
     *
     * @return RestDataObject
     *
     * @throws ServerRequestException
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {
        $object = $this->elementProvider->getElement($dataObject);

        $this->validate($object, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());

        $this->checkVoters($dataObject->getVoters(), $object);

        $this->deleteExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create(new BasicServerResponseModel()));

        return $dataObject;
    }
}