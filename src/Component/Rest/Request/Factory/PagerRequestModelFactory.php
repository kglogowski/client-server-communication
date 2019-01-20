<?php

namespace CSC\Server\Request\Factory;

use CSC\Component\Resolver\FilterResolver;
use CSC\Component\Resolver\SortResolver;
use CSC\Model\PagerRequestModel;
use CSC\Server\DataObject\PagerDataObjectInterface;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;

/**
 * Class PagerRequestModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerRequestModelFactory
{
    /**
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PagerRequestModel
     * @throws \Exception
     */
    public function create(PagerDataObjectInterface $dataObject): PagerRequestModel
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
            ->setLimit($dataObjectParameters['limit'])
            ->setPage($dataObjectParameters['page'])
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
        return ['filter', 'sort', 'limit', 'page'];
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