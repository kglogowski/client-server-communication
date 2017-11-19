<?php

namespace CSC\Protocol\Rest\Server\Provider;

use Doctrine\ORM\Query;

/**
 * Class QueryCountProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class QueryCountProvider
{
    const COUNT_ITEMS_QUERY_REPLACE_FROM = '/SELECT (.+) FROM/';
    const COUNT_ITEMS_QUERY_REPLACE_TO = 'SELECT COUNT(DISTINCT $1) FROM';

    const ORDER_BY_ITEMS_QUERY_REPLACE_FROM = '/ORDER BY.*/';
    const ORDER_BY_ITEMS_QUERY_REPLACE_TO = '';

    const GROUP_BY_ITEMS_QUERY_REPLACE_FROM = '/GROUP BY.*/';
    const GROUP_BY_ITEMS_QUERY_REPLACE_TO = '';

    /**
     * @param Query $query
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countItems(Query $query): int
    {
        $parameters = $query->getParameters();

        $query = clone $query;

        $query->setParameters($parameters);
        $query->setMaxResults(null);
        $query->setFirstResult(null);
        $query->setDQL(preg_replace(self::ORDER_BY_ITEMS_QUERY_REPLACE_FROM, self::ORDER_BY_ITEMS_QUERY_REPLACE_TO, $query->getDQL()));
        $query->setDQL(preg_replace(self::GROUP_BY_ITEMS_QUERY_REPLACE_FROM, self::GROUP_BY_ITEMS_QUERY_REPLACE_TO, $query->getDQL()));
        $query->setDQL(preg_replace(self::COUNT_ITEMS_QUERY_REPLACE_FROM, self::COUNT_ITEMS_QUERY_REPLACE_TO, $query->getDQL()));

        return $query->getSingleResult(Query::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @param int $count
     * @param int $limit
     *
     * @return int
     */
    public function countPages(int $count, int $limit): int
    {
        return ceil($count / $limit);
    }
}