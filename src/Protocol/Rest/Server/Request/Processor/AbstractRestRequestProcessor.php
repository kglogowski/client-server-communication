<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Provider\EntityManagerProvider;
use CSC\Server\Request\Processor\AbstractServerRequestProcessor;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractRestRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractRestRequestProcessor extends AbstractServerRequestProcessor implements RestRequestProcessor
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var array
     */
    protected $simpleDataObjectConfiguration;

    /**
     * {@inheritdoc}
     */
    public function setupDataObject(RestDataObject $dataObject): RestDataObject
    {
        $dataObject->setHttpMethod($this->getCurrentRequest()->getMethod());

        return $dataObject;
    }

    /**
     * @param object         $model
     * @param RestDataObject $dataObject
     */
    public function validateExternalObject($model, RestDataObject $dataObject)
    {
        $this->validate($model, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());
    }

    /**
     * @param RestDataObject $dataObject
     */
    public function validateDataObject(RestDataObject $dataObject)
    {
        $this->validate($dataObject, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());
    }

    /**
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function setEntityManager(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param array $simpleDataObjectConfiguration
     */
    public function setSimpleDataObjectConfiguration(array $simpleDataObjectConfiguration)
    {
        $this->simpleDataObjectConfiguration = $simpleDataObjectConfiguration;
    }
}