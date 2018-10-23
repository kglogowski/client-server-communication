<?php

namespace CSC\Server\Request\Factory;

use CSC\Model\PagerRequestModel;
use CSC\Component\Resolver\SortResolver;
use CSC\Component\Resolver\FilterResolver;
use CSC\Server\DataObject\PagerDataObject;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class PlainPagerRequestModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PlainPagerRequestModelFactory
{
    /**
     * @param PagerDataObject $dataObject
     *
     * @return PagerRequestModel
     *
     * @throws ServerRequestException
     */
    public function create(PagerDataObject $dataObject): PagerRequestModel
    {
        $missingKeys = $this->getMissingKeys($dataObject->getParameters());

        if (0 !== count($missingKeys)) {
            throw new ServerRequestException(ServerException::ERROR_TYPE_INVALID_PARAMETER, sprintf('Forgot required parameters'), $missingKeys);
        }

        return $this->createInstance($dataObject);
    }

    /**
     * @param PagerDataObject $dataObject
     *
     * @return PagerRequestModel
     */
    protected function createInstance(PagerDataObject $dataObject): PagerRequestModel
    {
        $requestModel = new PagerRequestModel();
        $dataObjectParameters = $dataObject->getParameters();

        return $requestModel
            ->setFilter((new FilterResolver())->resolveParams($dataObjectParameters['filter']))
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