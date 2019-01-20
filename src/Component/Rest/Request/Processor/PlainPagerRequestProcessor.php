<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Model\PagerRequestModel;
use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\PagerDataObject;
use CSC\Component\Rest\Request\Provider\QueryProvider;
use CSC\Component\Rest\Request\Factory\PlainPagerRequestModelFactory;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Component\Rest\Response\Model\PlainPagerResponseModel;

/**
 * Class PlainPagerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PlainPagerRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var PlainPagerRequestModelFactory
     */
    protected $requestModelFactory;

    /**
     * @var QueryProvider
     */
    protected $queryProvider;

    /**
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * ServerPlainPagerOrderedDataRequestProcessor constructor.
     *
     * @param PlainPagerRequestModelFactory $requestModelFactory
     * @param QueryProvider                 $queryProvider
     * @param ResponseModelFactory          $responseModelFactory
     */
    public function __construct(
        PlainPagerRequestModelFactory $requestModelFactory,
        QueryProvider $queryProvider,
        ResponseModelFactory $responseModelFactory
    )
    {
        $this->requestModelFactory = $requestModelFactory;
        $this->queryProvider = $queryProvider;
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

        /** @var PagerDataObject $dataObject */
        $requestModel = $this->requestModelFactory->create($dataObject);

        $query = $this->queryProvider->generateQuery($requestModel, $dataObject);

        $items = $query->getResult();
        $items = $this->processData($requestModel, $items);

        $responseObject = (new PlainPagerResponseModel())
            ->setItems($items)
            ->setHref($this->getCurrentRequest()->getUri())
        ;

        $dataObject->setResponseModel($this->responseModelFactory->create($responseObject));

        return $dataObject;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param PagerRequestModel $requestModel
     * @param array             $items
     *
     * @return array
     */
    protected function processData(PagerRequestModel $requestModel, array $items): array
    {
        return $items;
    }
}