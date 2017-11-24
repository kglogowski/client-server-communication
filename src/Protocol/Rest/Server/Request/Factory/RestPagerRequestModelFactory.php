<?php

namespace CSC\Protocol\Rest\Server\Request\Factory;

use CSC\Component\Resolver\QueryParameterResolver;
use CSC\Component\Resolver\SortResolver;
use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Model\PagerRequestModel;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;

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
     * @return PagerRequestModel
     *
     * @throws ServerRequestException
     */
    public function create(RestPagerDataObject $dataObject): PagerRequestModel
    {
        $missingKeys = $this->getMissingKeys($dataObject->getParameters());

        if (0 !== count($missingKeys)) {
            throw new ServerRequestException(
                ServerException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_FORGOT_REQUIRED_PARAMETERS,
                $missingKeys
            );
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