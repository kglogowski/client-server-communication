<?php

namespace CSC\Server\Request\Paginator;

use CSC\Server\DataObject\PagerDataObject;
use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;

/**
 * Interface PagerPaginatorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerPaginator
{
    /**
     * @param PagerRequestModel   $requestModel
     * @param PagerDataObject $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(PagerRequestModel $requestModel, PagerDataObject $dataObject): PaginatorModel;
}