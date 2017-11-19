<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Provider\RestQueryProvider;
use CSC\Protocol\Rest\Server\Request\Factory\RestPagerRequestModelFactory;
use CSC\Protocol\Rest\Server\Request\Paginator\RestPagerPaginator;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Protocol\Rest\Server\Response\Model\RestPagerResponseModel;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class RestPagerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var RestPagerRequestModelFactory
     */
    protected $requestModelFactory;

    /**
     * @var RestQueryProvider
     */
    protected $queryProvider;

    /**
     * @var RestPagerPaginator
     */
    protected $paginator;

    /**
     * @var RestResponseModelFactory
     */
    protected $restResponseModelFactory;

    /**
     * PagerOrderedRequestProcessor constructor.
     *
     * @param RestPagerRequestModelFactory $requestModelFactory
     * @param RestQueryProvider            $queryProvider
     * @param RestPagerPaginator           $paginator
     * @param RestResponseModelFactory     $restResponseModelFactory
     */
    public function __construct(
        RestPagerRequestModelFactory $requestModelFactory,
        RestQueryProvider $queryProvider,
        RestPagerPaginator $paginator,
        RestResponseModelFactory $restResponseModelFactory
    )
    {
        $this->requestModelFactory = $requestModelFactory;
        $this->queryProvider = $queryProvider;
        $this->paginator = $paginator;
        $this->restResponseModelFactory = $restResponseModelFactory;
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return RestDataObject
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {

        $this->setupDataObject($dataObject);

        $this->validate($dataObject, $dataObject->getValidationGroups(), $dataObject->supportedValidationGroups());

        /** @var RestPagerDataObject $dataObject */
        $requestModel = $this->requestModelFactory->create($dataObject);

        $query = $this->queryProvider->generateQuery($requestModel, $dataObject);

        $requestModel->setQuery($query);

        $paginationModel = $this->paginator->paginate($requestModel, $dataObject);

        $responseModel = (new RestPagerResponseModel())
            ->setCount($paginationModel->getCount())
            ->setPage($paginationModel->getPage())
            ->setPerPage($paginationModel->getPerPage())
            ->setItems($paginationModel->getItems())
            ->setHref($this->requestStack->getCurrentRequest()->getUri())
        ;

        $dataObject->setResponseModel($this->restResponseModelFactory->create($responseModel));

        return $dataObject;
    }
}