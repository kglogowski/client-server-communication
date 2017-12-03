<?php

namespace CSC\Protocol\Rest\Server\Provider;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Server\Exception\ServerException;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\ORM\EntityManager;

/**
 * Class RestGetElementProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestGetElementProvider
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * GetElementSimpleProvider constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function __construct(EntityManagerProvider $entityManagerProvider)
    {
        $this->em = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return ServerResponseModel
     *
     * @throws \Exception
     * @throws ServerRequestException
     */
    public function getElement(RestDataObject $dataObject): ServerResponseModel
    {
        $repository = $this->em->getRepository($dataObject->getEntityName());

        $element = $repository->findOneBy($dataObject->getRoutingQuery());

        if (null === $element) {
            throw new ServerRequestException(
                ServerException::ERROR_TYPE_RESOURCE_NOT_FOUND,
                TranslateDictionary::KEY_ELEMENT_DOES_NOT_EXIST
            );
        }

        if (!$element instanceof ServerResponseModel) {
            throw new \Exception(sprintf('Class "%s" must implement interface: "%s"',
                get_class($element),
                ServerResponseModel::class
            ));
        }

        return $element;
    }
}