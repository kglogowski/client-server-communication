<?php

namespace CSC\Protocol\Rest\Server\Request\Paginator;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Provider\QueryCountProvider;
use CSC\Protocol\Rest\Server\Provider\QueryItemsProvider;
use CSC\Protocol\Rest\Server\Request\Model\PagerPaginatorModel;
use CSC\Protocol\Rest\Server\Request\Model\RestPagerRequestModel;

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
     * @param RestPagerRequestModel $requestModel
     * @param RestPagerDataObject   $dataObject
     *
     * @return PagerPaginatorModel
     */
    public function paginate(RestPagerRequestModel $requestModel, RestPagerDataObject $dataObject): PagerPaginatorModel
    {
        $count = $this->countProvider->countItems($requestModel->getQuery());
        $items = $this->itemsProvider->getItems($requestModel->getQuery());

        //TODO Dorobić obróbkę danych jak będzie taka potrzeba $this->itemsResolver->resolve($items, $dataObject);

        return (new PagerPaginatorModel())
            ->setCount($count)
            ->setItems($items)
            ->setPage($requestModel->getPage())
            ->setPerPage($requestModel->getLimit())
            ;
    }
}