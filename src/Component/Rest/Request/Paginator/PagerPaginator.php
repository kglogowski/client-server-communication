<?php

namespace CSC\Server\Request\Paginator;

use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;
use CSC\Server\DataObject\PagerDataObjectInterface;

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