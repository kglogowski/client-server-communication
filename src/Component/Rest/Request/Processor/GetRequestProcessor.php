<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Doctrine\Provider\GetElementProvider;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Component\Rest\Response\Model\ServerResponseModel;

/**
 * Class GetRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class GetRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var GetElementProvider
     */
    protected $elementProvider;

    /**
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * GetRequestProcessor constructor.
     *
     * @param GetElementProvider   $elementProvider
     * @param ResponseModelFactory $responseModelFactory
     */
    public function __construct(GetElementProvider $elementProvider, ResponseModelFactory $responseModelFactory)
    {
        $this->elementProvider = $elementProvider;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return DataObject
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
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