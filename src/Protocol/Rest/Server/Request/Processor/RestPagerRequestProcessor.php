<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Provider\RestQueryProvider;
use CSC\Protocol\Rest\Server\Request\Factory\RestPagerRequestModelFactory;
use CSC\Protocol\Rest\Server\Request\Paginator\RestPagerPaginator;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Protocol\Rest\Server\Response\Model\RestPagerResponseModel;

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
    protected $responseModelFactory;

    /**
     * PagerOrderedRequestProcessor constructor.
     *
     * @param RestPagerRequestModelFactory $requestModelFactory
     * @param RestQueryProvider            $queryProvider
     * @param RestPagerPaginator           $paginator
     * @param RestResponseModelFactory     $responseModelFactory
     */
    public function __construct(
        RestPagerRequestModelFactory $requestModelFactory,
        RestQueryProvider $queryProvider,
        RestPagerPaginator $paginator,
        RestResponseModelFactory $responseModelFactory
    )
    {
        $this->requestModelFactory = $requestModelFactory;
        $this->queryProvider = $queryProvider;
        $this->paginator = $paginator;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return RestDataObject
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {

        $this->setupDataObject($dataObject);

        $this->validate($dataObject, $dataObject->getValidationGroups());

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

        $dataObject->setResponseModel($this->responseModelFactory->create($responseModel));

        return $dataObject;
    }
}