<?php

namespace CSC\Server\Request\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\PagerDataObject;
use CSC\Server\Provider\QueryProvider;
use CSC\Server\Request\Factory\PagerRequestModelFactory;
use CSC\Server\Request\Paginator\PagerPaginator;
use CSC\Server\Response\Factory\ResponseModelFactory;
use CSC\Server\Response\Model\PagerResponseModel;

/**
 * Class PagerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var PagerRequestModelFactory
     */
    protected $requestModelFactory;

    /**
     * @var QueryProvider
     */
    protected $queryProvider;

    /**
     * @var PagerPaginator
     */
    protected $paginator;

    /**
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * PagerOrderedRequestProcessor constructor.
     *
     * @param PagerRequestModelFactory $requestModelFactory
     * @param QueryProvider            $queryProvider
     * @param PagerPaginator           $paginator
     * @param ResponseModelFactory     $responseModelFactory
     */
    public function __construct(
        PagerRequestModelFactory $requestModelFactory,
        QueryProvider $queryProvider,
        PagerPaginator $paginator,
        ResponseModelFactory $responseModelFactory
    )
    {
        $this->requestModelFactory = $requestModelFactory;
        $this->queryProvider = $queryProvider;
        $this->paginator = $paginator;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return DataObject
     */
    public function process(DataObject $dataObject): DataObject
    {

        $this->setupDataObject($dataObject);

        $this->validate($dataObject, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());

        /** @var PagerDataObject $dataObject */
        $requestModel = $this->requestModelFactory->create($dataObject);

        $query = $this->queryProvider->generateQuery($requestModel, $dataObject);

        $requestModel->setQuery($query);

        $paginationModel = $this->paginator->paginate($requestModel, $dataObject);

        $responseModel = (new PagerResponseModel())
            ->setCount($paginationModel->getCount())
            ->setPage($paginationModel->getPage())
            ->setPerPage($paginationModel->getPerPage())
            ->setItems($paginationModel->getItems())
            ->setHref($this->requestStack->getCurrentRequest()->getUri())
        ;

        $dataObject->setResponseModel($this->responseModelFactory->create($responseModel));

        return $dataObject;
    }
}