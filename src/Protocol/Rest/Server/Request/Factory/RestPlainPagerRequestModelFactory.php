<?php

namespace CSC\Protocol\Rest\Server\Request\Factory;

use CSC\Model\PagerRequestModel;
use CSC\Protocol\Rest\Resolver\SortResolver;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Resolver\QueryParameterResolver;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class RestPlainPagerRequestModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPlainPagerRequestModelFactory
{
    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return PagerRequestModel
     *
     * @throws ServerRequestException
     */
    public function create(RestPagerDataObject $dataObject): PagerRequestModel
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
     * @return PagerRequestModel
     */
    protected function createInstance(RestPagerDataObject $dataObject): PagerRequestModel
    {
        $requestModel = new PagerRequestModel();
        $dataObjectParameters = $dataObject->getParameters();

        return $requestModel
            ->setFilter((new QueryParameterResolver())->resolveParams($dataObjectParameters['filter']))
            ->setSort((new SortResolver())->resolveParams($dataObjectParameters['sort']))
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
        return ['filter', 'sort', 'methodName'];
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