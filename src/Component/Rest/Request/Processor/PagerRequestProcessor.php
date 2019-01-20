<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\PagerDataObjectInterface;
use CSC\Component\Rest\Request\Provider\QueryProvider;
use CSC\Component\Rest\Request\Factory\PagerRequestModelFactory;
use CSC\Component\Rest\Request\Paginator\PagerPaginator;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Component\Rest\Response\Model\PagerResponseModel;

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
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
    {
        $this->setupDataObject($dataObject);

        $this->validate($dataObject, $dataObject->getValidationGroups());

        /** @var PagerDataObjectInterface $dataObject */
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