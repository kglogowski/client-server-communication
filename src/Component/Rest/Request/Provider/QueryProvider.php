<?php

namespace CSC\Server\Provider;

use CSC\Server\DataObject\PagerDataObject;
use CSC\Model\PagerRequestModel;
use Doctrine\ORM\Query;

/**
 * Interface QueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface QueryProvider
{
    /**
     * @param PagerRequestModel   $requestModel
     * @param PagerDataObject $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, PagerDataObject $dataObject): Query;
}