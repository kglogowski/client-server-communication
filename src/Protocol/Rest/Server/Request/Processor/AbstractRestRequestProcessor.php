<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Server\Request\Processor\AbstractServerRequestProcessor;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;

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
     * @var Serializer
     */
    protected $serializer;

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
        $this->validate($model, $dataObject->getValidationGroups());
    }

    /**
     * @param RestDataObject $dataObject
     */
    public function validateDataObject(RestDataObject $dataObject)
    {
        $this->validate($dataObject, $dataObject->getValidationGroups());
    }

    /**
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function setEntityManager(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $modelString
     * @param string $classType
     *
     * @return mixed
     */
    public function deserialize(string $modelString, string $classType)
    {
        return $this->serializer->deserialize($modelString, $classType, 'json');
    }
}