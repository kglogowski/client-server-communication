<?php

namespace CSC\Protocol\Rest\Server\Provider;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PagerRequestModel;
use CSC\Provider\EntityManagerProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class RestBasicQueryProvider implements RestQueryProvider
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * QueryProvider constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function __construct(EntityManagerProvider $entityManagerProvider)
    {
        $this->em = $entityManagerProvider->getEntityManager();
    }

    /**
     * @param PagerRequestModel   $requestModel
     * @param RestPagerDataObject $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, RestPagerDataObject $dataObject): Query
    {
        $methodName = $requestModel->getMethodName();
        $entityName = $requestModel->getEntityName();

        $repository = $this->em->getRepository($entityName);

        if (!method_exists($repository, $methodName)) {
            throw new \LogicException(sprintf('Incorrect method name'));
        }

        return $repository->$methodName($requestModel);
    }
}