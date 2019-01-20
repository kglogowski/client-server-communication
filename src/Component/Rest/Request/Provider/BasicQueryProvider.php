<?php

namespace CSC\Component\Rest\Request\Provider;

use CSC\Model\PagerRequestModel;
use CSC\Component\Doctrine\Provider\EntityManagerProvider;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;
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
     * @param PagerRequestModel        $requestModel
     * @param PagerDataObjectInterface $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, PagerDataObjectInterface $dataObject): Query
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