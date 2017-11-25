<?php

namespace CSC\Tests\Repository;
use CSC\Model\PagerRequestModel;
use CSC\Protocol\Rest\Builder\PagerQueryBuilderAware;
use CSC\Protocol\Rest\Builder\RestPagerQueryBuilder;
use CSC\Tests\ORM\EntityManagerProviderMock;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractTestRepository
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractTestRepository implements PagerQueryBuilderAware
{
    const TEST_METHOD_NAME = 'testMethod';

    /**
     * @var RestPagerQueryBuilder
     */
    protected $builder;

    /**
     * @param $id
     *
     * @return mixed
     */
    abstract public function find($id);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return mixed
     */
    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return mixed
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param PagerRequestModel $model
     *
     * @return mixed
     */
    abstract public function testMethod(PagerRequestModel $model);

    /**
     * @return string
     */
    abstract protected function getEntityName(): string;

    /**
     * @return string
     */
    abstract protected function getAlias(): string;

    /**
     * @param RestPagerQueryBuilder $builder
     */
    public function setPagerQueryBuilder(RestPagerQueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getQueryBuilder(AbstractTestRepository $repository, ?string $indexBy = null): QueryBuilder
    {
        $entityManagerProvider = (new EntityManagerProviderMock())->getEntityManagerProvider($repository);
        $em = $entityManagerProvider->getEntityManager();

        return $em->createQueryBuilder()
            ->select($this->getAlias())
            ->from($this->getEntityName(), $this->getAlias(), $indexBy)
        ;
    }
}