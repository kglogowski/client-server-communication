<?php

namespace CSC\Component\Rest\Request\Factory;

use CSC\Model\PagerRequestModel;
use CSC\Component\Rest\Request\Resolver\SortResolver;
use CSC\Component\Rest\Request\Resolver\FilterResolver;
use CSC\Component\Rest\DataObject\PagerDataObject;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;
use CSC\Exception\ServerException;
use CSC\Exception\ServerRequestException;

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
     * @throws \Exception
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
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PagerRequestModel
     * @throws \Exception
     */
    protected function createInstance(PagerDataObjectInterface $dataObject): PagerRequestModel
    {
        $requestModel = new PagerRequestModel();
        $dataObjectParameters = $dataObject->getParameters();

        return $requestModel
            ->setFilter((new FilterResolver())->resolveParams($dataObjectParameters['filter']))
            ->setSort((new SortResolver())->resolveParams($dataObjectParameters['sort']))
            ->setRoutingParameters($dataObjectParameters['routingParameters'])
            ->setMethodName($dataObject->getMethodName())
            ->setEntityName($dataObject->getEntityName())
        ;
    }

    /**
     * @return array
     */
    protected function getRequiredKeys(): array
    {
        return ['filter', 'sort'];
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