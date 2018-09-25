<?php

namespace CSC\Server\Provider;

use CSC\Server\DataObject\PagerDataObject;
use CSC\Model\PagerRequestModel;
use CSC\Component\Provider\EntityManagerProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class BasicQueryProvider implements QueryProvider
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
     * @param PagerDataObject $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, PagerDataObject $dataObject): Query
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