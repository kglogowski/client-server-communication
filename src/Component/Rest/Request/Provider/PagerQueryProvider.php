<?php

namespace CSC\Server\Provider;

use CSC\Model\Interfaces\UserInterface;
use CSC\Component\Auth\Interfaces\GuardUserAware;
use CSC\Component\Builder\PagerQueryBuilderAware;
use CSC\Component\Builder\PagerQueryBuilder;
use CSC\Server\DataObject\DataObject;
use CSC\Model\PagerRequestModel;
use CSC\Component\Provider\UserProvider;
use CSC\Component\Provider\EntityManagerProvider;
use CSC\Server\DataObject\PagerDataObjectInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

/**
 * Class PagerQueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerQueryProvider implements QueryProvider
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var PagerQueryBuilder
     */
    protected $pagerOrderedQueryBuilder;

    /**
     * @var array
     */
    protected $userProvider;

    /**
     * PagerOrderedQueryProvider constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     * @param PagerQueryBuilder     $pagerOrderedQueryBuilder
     * @param UserProvider          $userProvider
     */
    public function __construct(
        EntityManagerProvider $entityManagerProvider,
        PagerQueryBuilder $pagerOrderedQueryBuilder,
        UserProvider $userProvider
    )
    {
        $this->em = $entityManagerProvider->getEntityManager();
        $this->pagerOrderedQueryBuilder = $pagerOrderedQueryBuilder;
        $this->userProvider = $userProvider;
    }

    /**
     * @param PagerRequestModel        $requestModel
     * @param PagerDataObjectInterface $dataObject
     *
     * @return Query
     *
     * @throws \Exception
     */
    public function generateQuery(PagerRequestModel $requestModel, PagerDataObjectInterface $dataObject): Query
    {
        $methodName = $requestModel->getMethodName();
        $entityName = $requestModel->getEntityName();

        $repository = $this->em->getRepository($entityName);

        if (!$repository instanceof PagerQueryBuilderAware) {
            throw new \LogicException(sprintf('"%s" must implement PagerQueryBuilderAware', get_class($repository)));
        }

        $repository->setPagerQueryBuilder($this->pagerOrderedQueryBuilder);

        if ($repository instanceof GuardUserAware) {
            $user = $this->userProvider->getUser();

            if ($user instanceof UserInterface) {
                $repository->setUser($this->userProvider->getUser());
            }
        }

        $this->pagerOrderedQueryBuilder->setSupportFilterParameters($dataObject->getValue(DataObject::VALUE_AVAILABLE_FILTER, []));
        $this->pagerOrderedQueryBuilder->setSupportSortParameters($dataObject->getValue(DataObject::VALUE_AVAILABLE_SORT, []));

        return $repository->$methodName($requestModel);
    }
}