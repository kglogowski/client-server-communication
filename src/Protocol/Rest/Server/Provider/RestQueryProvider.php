<?php

namespace CSC\Protocol\Rest\Server\Provider;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PagerRequestModel;
use Doctrine\ORM\Query;

/**
 * Interface RestQueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestQueryProvider
{
    /**
     * @param PagerRequestModel   $requestModel
     * @param RestPagerDataObject $dataObject
     *
     * @return Query
     */
    public function generateQuery(PagerRequestModel $requestModel, RestPagerDataObject $dataObject): Query;
}