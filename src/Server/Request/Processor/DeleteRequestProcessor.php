<?php

namespace CSC\Server\Request\Processor;

use CSC\Component\Executor\DeleteExecutor;
use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\SimpleDataObject;
use CSC\Server\Provider\GetElementProvider;
use CSC\Server\Response\Factory\ResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Server\Response\Model\BasicServerResponseModel;

/**
 * Class DeleteRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DeleteRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var GetElementProvider
     */
    protected $elementProvider;

    /**
     * @var DeleteExecutor
     */
    protected $deleteExecutor;

    /**
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * DeleteRequestProcessor constructor.
     *
     * @param GetElementProvider   $elementProvider
     * @param DeleteExecutor           $deleteExecutor
     * @param ResponseModelFactory $responseModelFactory
     */
    public function __construct(
        GetElementProvider $elementProvider,
        DeleteExecutor $deleteExecutor,
        ResponseModelFactory $responseModelFactory
    )
    {
        $this->elementProvider = $elementProvider;
        $this->deleteExecutor = $deleteExecutor;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param DataObject|SimpleDataObject $dataObject
     *
     * @return DataObject
     *
     * @throws ServerRequestException
     */
    public function process(DataObject $dataObject): DataObject
    {
        $object = $this->elementProvider->getElement($dataObject);

        $this->validate($object, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());

        $this->checkVoters($dataObject->getVoters(), $object);

        $this->deleteExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create(new BasicServerResponseModel()));

        return $dataObject;
    }
}