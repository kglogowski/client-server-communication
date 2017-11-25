<?php

namespace CSC\Tests\Repository;

use CSC\Model\PagerRequestModel;
use CSC\Tests\Model\ModelMock;
use Doctrine\Common\Util\Inflector;

/**
 * Class ModelMockRepository
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ModelMockRepository extends AbstractTestRepository
{
    const ALIAS = 'mock';

    /**
     * @param $id
     *
     * @return ModelMock
     */
    public function find($id)
    {
        return (new ModelMock())
            ->setId($id)
        ;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return ModelMock
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $model = new ModelMock();

        foreach ($criteria as $key => $criterion) {
            $key = 'set'.Inflector::classify($key);

            $model->$key($criterion);
        }

        return $model;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return [(new ModelMock())];
    }

    /**
     * @param PagerRequestModel $model
     *
     * @return array
     *
     * @throws \Exception
     */
    public function testMethod(PagerRequestModel $model): array
    {
        $result = $this->builder
            ->setQueryBuilder($this->getQueryBuilder($this))
            ->addFilters($model->getFilter(), 'mock')
            ->addSorts($model->getSort(), 'mock')
            ->getResult()
        ;

        throw new \Exception($result->getDQL());
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return ModelMock::class;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return self::ALIAS;
    }
}