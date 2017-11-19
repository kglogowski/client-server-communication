<?php

namespace CSC\Protocol\Rest\Server\Provider;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Request\Model\RestPagerRequestModel;
use Doctrine\ORM\Query;

/**
 * Interface RestQueryProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestQueryProvider
{
    /**
     * @param RestPagerRequestModel $requestModel
     * @param RestPagerDataObject   $dataObject
     *
     * @return Query
     */
    public function generateQuery(RestPagerRequestModel $requestModel, RestPagerDataObject $dataObject): Query;
}