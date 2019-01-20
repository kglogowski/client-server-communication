<?php

namespace CSC\Component\Rest\Request\Resolver;

use CSC\Component\Rest\Request\Builder\QueryFilterBuilder;
use CSC\Model\QueryFilterModel;
use CSC\Exception\ServerException;
use CSC\Exception\ServerRequestException;
use CSC\Translate\TranslateDictionary;

/**
 * Class FilterResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class FilterResolver
{
    /**
     * @param string $filter
     *
     * @return array
     *
     * @throws ServerRequestException
     */
    public function resolveParams(string $filter): array
    {
        $filterElements = [];

        preg_match_all('/(\[.*?])/', $filter, $filters);

        foreach ($filters[0] as $filterElement) {
            $parameters = $this->getParameters($filterElement);

            if (!$this->hasOperator($parameters->getOperator())) {
                throw new ServerRequestException(
                    ServerException::ERROR_TYPE_INVALID_PARAMETER,
                    TranslateDictionary::KEY_BAD_OPERATOR_IN_FILTER,
                    [$parameters->getField() => $parameters->getOperator()]
                );
            }

            $filterElements[] = $parameters;
        }

        return $filterElements;
    }

    /**
     * @return array
     */
    private function getOperators(): array
    {
        return [
            QueryFilterBuilder::DATETIME,
            QueryFilterBuilder::NOT_NULL,
            QueryFilterBuilder::IS_NULL,
            QueryFilterBuilder::RANGE,
            QueryFilterBuilder::IN,
            QueryFilterBuilder::NOT_IN,
            QueryFilterBuilder::INTEGER,
            QueryFilterBuilder::ENTITY,
            QueryFilterBuilder::BOOLEAN,
            QueryFilterBuilder::TYPE_ACTIVE,
            QueryFilterBuilder::INT,
            QueryFilterBuilder::EQUAL,
            QueryFilterBuilder::GT,
            QueryFilterBuilder::GTE,
            QueryFilterBuilder::LT,
            QueryFilterBuilder::LTE,
            QueryFilterBuilder::LIKE_TEXT,
            QueryFilterBuilder::TEXT_LIKE,
            QueryFilterBuilder::LIKE_TEXT_LIKE,
            QueryFilterBuilder::TEXT,
            QueryFilterBuilder::RADIUS,
        ];
    }

    /**
     * @param string $operator
     *
     * @return bool
     */
    private function hasOperator(string $operator): bool
    {
        return true === in_array($operator, $this->getOperators());
    }

    /**
     * @param string $filterElement
     *
     * @return QueryFilterModel
     */
    private function getParameters(string $filterElement): QueryFilterModel
    {
        preg_match('/^\[(.+){(.+)}(.*)\]$/', $filterElement, $filterParameters);

        return (new QueryFilterModel())
            ->setField($filterParameters[1])
            ->setOperator($filterParameters[2])
            ->setValue($filterParameters[3])
        ;
    }
}