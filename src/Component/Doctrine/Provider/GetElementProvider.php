<?php

namespace CSC\Server\Provider;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Exception\ServerException;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\ORM\EntityManager;

/**
 * Class GetElementProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class GetElementProvider
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
     * @param DataObject $dataObject
     * @param string|null    $alias
     *
     * @return ServerResponseModel
     */
    public function getElement(DataObject $dataObject, ?string $alias = null): ServerResponseModel
    {
        return $this->getElementByParameters(
            $dataObject->getEntityName(),
            $dataObject->getRoutingQuery(),
            $alias
        );
    }

    /**
     * @param string      $entityName
     * @param array       $parameters
     * @param string|null $alias
     *
     * @return ServerResponseModel
     * @throws ServerRequestException
     * @throws \Exception
     */
    public function getElementByParameters(string $entityName, array $parameters, ?string $alias = null): ServerResponseModel
    {
        $repository = $this->em->getRepository($entityName);

        $element = $repository->findOneBy($parameters);

        if (null === $element) {
            throw new ServerRequestException(
                ServerException::ERROR_TYPE_RESOURCE_NOT_FOUND,
                TranslateDictionary::KEY_ELEMENT_DOES_NOT_EXIST,
                $alias
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