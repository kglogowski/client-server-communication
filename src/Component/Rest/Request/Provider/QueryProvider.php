<?php

namespace CSC\Component\Rest\Request\Provider;

use CSC\Model\PagerRequestModel;
use CSC\Server\DataObject\PagerDataObjectInterface;
use Doctrine\ORM\Query;

/**
 * Interface QueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface QueryProvider
{
    /**
     * @param PagerRequestModel        $requestModel
     * @param PagerDataObjectInterface $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, PagerDataObjectInterface $dataObject): Query;
}