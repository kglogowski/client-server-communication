<?php

namespace CSC\Protocol\Rest\Server\Request\Paginator;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Component\Provider\QueryCountProvider;
use CSC\Component\Provider\QueryItemsProvider;
use CSC\Model\PaginatorModel;
use CSC\Model\PagerRequestModel;

/**
 * Class RestBasicPagerPaginator
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestBasicPagerPaginator implements RestPagerPaginator
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
     * @param RestPagerDataObject $dataObject
     *
     * @return PaginatorModel
     */
    public function paginate(PagerRequestModel $requestModel, RestPagerDataObject $dataObject): PaginatorModel
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