<?php

namespace CSC\Component\Rest\Request\Paginator;

use CSC\Component\Provider\QueryCountProvider;
use CSC\Component\Provider\QueryItemsProvider;
use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;
use CSC\Server\DataObject\PagerDataObjectInterface;

/**
 * Class BasicPagerPaginator
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class BasicPagerPaginator implements PagerPaginator
{
    /**
     * @var QueryCountProvider
     */
    protected $countProvider;

    /**
     * @var QueryItemsProvider
     */
    protected $itemsProvider;

    /**
     * PagerOrderedDataPaginator constructor.
     *
     * @param QueryCountProvider $countProvider
     * @param QueryItemsProvider $itemsProvider
     */
    public function __construct(QueryCountProvider $countProvider, QueryItemsProvider $itemsProvider)
    {
        $this->countProvider = $countProvider;
        $this->itemsProvider = $itemsProvider;
    }

    /**
     * @param PagerRequestModel        $requestModel
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PaginatorModel
     * @throws \Exception
     */
    public function paginate(PagerRequestModel $requestModel, PagerDataObjectInterface $dataObject): PaginatorModel
    {
        $count = $this->countProvider->countItems($requestModel->getQuery());
        $items = $this->itemsProvider->getItems($requestModel->getQuery());

        return (new PaginatorModel())
            ->setCount($count)
            ->setItems($items)
            ->setPage($requestModel->getPage())
            ->setPerPage($requestModel->getLimit())
        ;
    }
}