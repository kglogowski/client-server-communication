<?php

namespace CSC\Tests\Repository;

use CSC\Tests\Model\ModelMock;
use Doctrine\Common\Util\Inflector;

/**
 * Class ModelMockRepository
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ModelMockRepository extends AbstractTestRepository
{
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
}