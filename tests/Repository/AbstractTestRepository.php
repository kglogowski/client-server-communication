<?php

namespace CSC\Tests\Repository;

/**
 * Class AbstractTestRepository
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractTestRepository
{
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
}