<?php
/**
 * Created by PhpStorm.
 * User: Krzysiek
 * Date: 19.11.2017
 * Time: 19:53
 */

namespace CSC\Protocol\Rest\Resolver;


use CSC\Protocol\Rest\Modernizer\QueryBuilderFilterModernizer;
use CSC\Protocol\Rest\Server\Request\Model\QueryFilterModel;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;

class QueryParamResolver
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
                    'Bad operator in filters',
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
            QueryBuilderFilterModernizer::DATETIME,
            QueryBuilderFilterModernizer::NOT_NULL,
            QueryBuilderFilterModernizer::IS_NULL,
            QueryBuilderFilterModernizer::RANGE,
            QueryBuilderFilterModernizer::IN,
            QueryBuilderFilterModernizer::NOT_IN,
            QueryBuilderFilterModernizer::INTEGER,
            QueryBuilderFilterModernizer::ENTITY,
            QueryBuilderFilterModernizer::BOOLEAN,
            QueryBuilderFilterModernizer::TYPE_ACTIVE,
            QueryBuilderFilterModernizer::INT,
            QueryBuilderFilterModernizer::EQUAL,
            QueryBuilderFilterModernizer::GT,
            QueryBuilderFilterModernizer::GTE,
            QueryBuilderFilterModernizer::LT,
            QueryBuilderFilterModernizer::LTE,
            QueryBuilderFilterModernizer::LIKE_TEXT,
            QueryBuilderFilterModernizer::TEXT_LIKE,
            QueryBuilderFilterModernizer::LIKE_TEXT_LIKE,
            QueryBuilderFilterModernizer::TEXT,
            QueryBuilderFilterModernizer::RADIUS,
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