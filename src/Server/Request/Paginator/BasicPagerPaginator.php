<?php

namespace CSC\Server\Request\Paginator;

use CSC\Server\DataObject\PagerDataObject;
use CSC\Component\Provider\QueryCountProvider;
use CSC\Component\Provider\QueryItemsProvider;
use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;

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
     * @param PagerRequestModel   $requestModel
     * @param PagerDataObject $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(PagerRequestModel $requestModel, PagerDataObject $dataObject): PaginatorModel
    {
        $count = $this->countProvider->countItems($requestModel->getQuery());
        $items = $this->itemsProvider->getItems($requestModel->getQuery());

        //TODO Dorobić obróbkę danych jak będzie taka potrzeba $this->itemsResolver->resolve($items, $dataObject);

        return (new PaginatorModel())
            ->setCount($count)
            ->setItems($items)
            ->setPage($requestModel->getPage())
            ->setPerPage($requestModel->getLimit())
        ;
    }
}