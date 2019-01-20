<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Doctrine\Executor\DeleteExecutor;
use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\SimpleDataObjectInterface;
use CSC\Component\Doctrine\Provider\GetElementProvider;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Component\Rest\Response\Model\BasicServerResponseModel;

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
     * @param DataObject|SimpleDataObjectInterface $dataObject
     *
     * @return DataObject
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
    {
        $object = $this->elementProvider->getElement($dataObject);

        $this->validate($object, $dataObject->getValidationGroups());

        $this->checkVoters($dataObject->getVoters(), $object);

        $this->deleteExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create(new BasicServerResponseModel()));

        return $dataObject;
    }
}