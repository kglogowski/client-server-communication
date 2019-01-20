<?php

namespace CSC\Server\Request\Processor;

use CSC\Model\PagerRequestModel;
use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\PagerDataObject;
use CSC\Server\Provider\QueryProvider;
use CSC\Server\Request\Factory\PlainPagerRequestModelFactory;
use CSC\Server\Response\Factory\ResponseModelFactory;
use CSC\Server\Response\Model\PlainPagerResponseModel;

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