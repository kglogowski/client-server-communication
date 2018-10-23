<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Model\PagerRequestModel;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Provider\RestQueryProvider;
use CSC\Protocol\Rest\Server\Request\Factory\RestPlainPagerRequestModelFactory;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Protocol\Rest\Server\Response\Model\RestPlainPagerResponseModel;

/**
 * Class RestPlainPagerRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPlainPagerRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var RestPlainPagerRequestModelFactory
     */
    protected $requestModelFactory;

    /**
     * @var RestQueryProvider
     */
    protected $queryProvider;

    /**
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * ServerRestPlainPagerOrderedDataRequestProcessor constructor.
     *
     * @param RestPlainPagerRequestModelFactory $requestModelFactory
     * @param RestQueryProvider                 $queryProvider
     * @param RestResponseModelFactory          $responseModelFactory
     */
    public function __construct(
        RestPlainPagerRequestModelFactory $requestModelFactory,
        RestQueryProvider $queryProvider,
        RestResponseModelFactory $responseModelFactory
    )
    {
        $this->requestModelFactory = $requestModelFactory;
        $this->queryProvider = $queryProvider;
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

        $items = $query->getResult();
        $items = $this->processData($requestModel, $items);

        $responseObject = (new RestPlainPagerResponseModel())
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