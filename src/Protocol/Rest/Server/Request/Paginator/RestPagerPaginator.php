<?php

namespace CSC\Protocol\Rest\Server\Request\Paginator;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PaginatorModel;
use CSC\Protocol\Rest\Server\Request\Model\RestPagerRequestModel;

/**
 * Interface RestPagerPaginatorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestPagerPaginator
{
    /**
     * @param RestPagerRequestModel $requestModel
     * @param RestPagerDataObject   $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(RestPagerRequestModel $requestModel, RestPagerDataObject $dataObject): PaginatorModel;
}