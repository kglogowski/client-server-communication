<?php

namespace CSC\Protocol\Rest\Server\Request\Factory;

use CSC\Protocol\Rest\Resolver\QueryParamResolver;
use CSC\Protocol\Rest\Resolver\RestPagerSortResolver;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\Request\Model\RestPagerRequestModel;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class RestPagerRequestModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerRequestModelFactory
{
    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return RestPagerRequestModel
     *
     * @throws ServerRequestException
     */
    public function create(RestPagerDataObject $dataObject): RestPagerRequestModel
    {
        $missingKeys = $this->getMissingKeys($dataObject->getParameters());

        if (0 !== count($missingKeys)) {
            throw new ServerRequestException(ServerException::ERROR_TYPE_INVALID_PARAMETER, sprintf('Forgot required parameters'), $missingKeys);
        }

        return $this->createInstance($dataObject);
    }

    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return RestPagerRequestModel
     */
    protected function createInstance(RestPagerDataObject $dataObject): RestPagerRequestModel
    {
        $requestModel = new RestPagerRequestModel();
        $dataObjectParameters = $dataObject->getParameters();

        return $requestModel
            ->setFilter((new QueryParamResolver())->resolveParams($dataObjectParameters['filter']))
            ->setSort((new RestPagerSortResolver())->resolveParams($dataObjectParameters['sort']))
            ->setLimit($dataObjectParameters['limit'])
            ->setPage($dataObjectParameters['page'])
            ->setRoutingParameters($dataObjectParameters['routingParameters'])
            ->setMethodName($dataObjectParameters['methodName'])
            ->setEntityName($dataObject->getEntityName())
            ;
    }

    /**
     * @return array
     */
    protected function getRequiredKeys(): array
    {
        return ['filter', 'sort', 'limit', 'page', 'methodName'];
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function getMissingKeys(array $parameters): array
    {
        return array_diff($this->getRequiredKeys(), array_keys($parameters));
    }
}