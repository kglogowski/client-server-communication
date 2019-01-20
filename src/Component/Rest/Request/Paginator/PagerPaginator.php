<?php

namespace CSC\Component\Rest\Request\Paginator;

use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;

/**
 * Interface PagerPaginatorInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerPaginator
{
    /**
     * @param PagerRequestModel        $requestModel
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(PagerRequestModel $requestModel, PagerDataObjectInterface $dataObject): PaginatorModel;
}