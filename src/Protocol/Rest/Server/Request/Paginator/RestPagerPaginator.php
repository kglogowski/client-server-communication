<?php

namespace CSC\Protocol\Rest\Server\Request\Paginator;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;

/**
 * Interface RestPagerPaginatorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestPagerPaginator
{
    /**
     * @param PagerRequestModel   $requestModel
     * @param RestPagerDataObject $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(PagerRequestModel $requestModel, RestPagerDataObject $dataObject): PaginatorModel;
}