<?php

namespace CSC\Protocol\Rest\Server\Provider;

use Doctrine\ORM\Query;

/**
 * Class QueryItemsProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class QueryItemsProvider
{
    /**
     * @param Query $query
     *
     * @return array
     */
    public function getItems(Query $query)
    {
        return $query->getResult();
    }
}