<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;
use CSC\Component\Rest\Response\Model\BasicServerResponseModel;
use CSC\Component\Rest\Response\Model\ServerResponseModel;
use CSC\Model\Traits\SoftDeleteTrait;

class SoftDeleteProcessor extends DeleteRequestProcessor
{
    /**
     * @param DataObject|SimpleDataObjectInterface|PagerDataObjectInterface $dataObject
     *
     * @return DataObject
     *
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
    {
        $this->setupDataObject($dataObject);

        /** @var SoftDeleteTrait|ServerResponseModel $object */
        $object = $this->elementProvider->getElement($dataObject);

        $this->validate($object, $dataObject->getValidationGroups());

        $this->checkVoters($dataObject->getVoters(), $object);

        $object->delete();
        $this->entityManager->flush($object);

        $dataObject->setResponseModel($this->responseModelFactory->create(new BasicServerResponseModel()));

        return $dataObject;
    }
}