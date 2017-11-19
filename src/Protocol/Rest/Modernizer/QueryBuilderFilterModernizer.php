<?php

namespace CSC\Protocol\Rest\Modernizer;


use CSC\Protocol\Rest\Server\Request\Model\QueryFilterModel;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Func;
use PDO;

/**
 * Class QueryBuilderFilterModernizer
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class QueryBuilderFilterModernizer
{
    /**
     * Sort
     */
    const DIRECTION_ASCENDING = 'asc';
    const DIRECTION_DESCENDING = 'desc';

    /**
     * Filters
     */
    const DATETIME = 'datetime';
    const NOT_NULL = 'notNull';
    const IS_NULL = 'isNull';
    const RANGE = 'range';
    const IN = 'in';
    const NOT_IN = 'notIn';
    const ENTITY = 'entity';
    const BOOLEAN = 'bool';
    const TYPE_ACTIVE = 'active';
    const INT = 'int';
    const INTEGER = 'integer';
    const EQUAL = 'eq';
    const GT = 'gt';
    const GTE = 'gte';
    const LT = 'lt';
    const LTE = 'lte';
    const LIKE_TEXT = '%text';
    const TEXT_LIKE = 'text%';
    const LIKE_TEXT_LIKE = '%text%';
    const TEXT = 'text';
    const RADIUS = 'radius';

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @param QueryBuilder     $queryBuilder
     * @param QueryFilterModel $filterModel
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    public function modernize(QueryBuilder $queryBuilder, QueryFilterModel $filterModel, $alias)
    {
        $camelCaseField = Inflector::camelize($filterModel->getField());

        $filterModel->setField($camelCaseField);

        switch ($filterModel->getOperator()) {
            case self::DATETIME:
                $qb = $this->addDateFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::NOT_NULL:
                $qb = $this->addNotNull($filterModel, $queryBuilder, $alias);
                break;
            case self::IS_NULL:
                $qb = $this->addIsNull($filterModel, $queryBuilder, $alias);
                break;
            case self::IN:
                $qb = $this->addInFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::NOT_IN:
                $qb = $this->addNotInFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::ENTITY:
                $qb = $this->addEntityFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::BOOLEAN:
                $qb = $this->addBooleanFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::TYPE_ACTIVE: //only when is set to true
                $qb = $this->addActiveFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::INT:
            case self::INTEGER:
            case self::EQUAL:
                $qb = $this->addEqualFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::GT:
                $qb = $this->addGtFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::GTE:
                $qb = $this->addGteFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::LT:
                $qb = $this->addLtFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::LTE:
                $qb = $this->addLteFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::RADIUS:
                $qb = $this->addRadiusFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::LIKE_TEXT:   //caseInsensitive
                $qb = $this->addLikeTextFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::TEXT_LIKE:   //caseInsensitive
                $qb = $this->addLikeTextFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::LIKE_TEXT_LIKE:   //caseInsensitive
                $qb = $this->addLikeTextFieldToQuery($filterModel, $queryBuilder, $alias);
                break;
            case self::TEXT:   //caseInsensitive
            default:
                $qb = $this->addTextFieldToQuery($filterModel, $queryBuilder, $alias);
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addDateFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());

        $values = explode(',', $filterModel->getValue());

        if (2 !== count($values)) {
            throw new \LogicException(sprintf('Incorrect parameter %s', $filterModel->getField()));
        }

        list($from, $to) = $values;
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s >= :%sFrom', $fieldName, $parameterName))
            ->setParameter(sprintf('%sFrom', $parameterName), $from);

        $qb->andWhere(sprintf('%s < :%sTo', $fieldName, $parameterName))
            ->setParameter(sprintf('%sTo', $parameterName), $to);

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addEqualFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $qb->andWhere(
                $qb->expr()->eq(
                    $fieldName,
                    sprintf(':%s', $parameterName)
                )
            )->setParameter($parameterName, sprintf('%s', $filterModel->getValue()));
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addNotNull(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s is not null', $fieldName));

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addIsNull(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s is null', $fieldName));

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addInFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s IN (:%s)', $fieldName, $parameterName))
            ->setParameter($parameterName, explode(',', $filterModel->getValue()));

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addNotInFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s NOT IN (:%s)', $fieldName, $parameterName))
            ->setParameter($parameterName, explode(',', $filterModel->getValue()));

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addEntityFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
            ->setParameter($parameterName, $filterModel->getValue());

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addBooleanFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(
            $qb->expr()->eq(
                $fieldName,
                sprintf(':%s', $parameterName)
            )
        )->setParameter($parameterName, filter_var($filterModel->getValue(), FILTER_VALIDATE_BOOLEAN), PDO::PARAM_BOOL);

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addActiveFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        $qb->andWhere(
            $qb->expr()->eq(
                $fieldName,
                sprintf(':%s', $parameterName)
            )
        )->setParameter($parameterName, filter_var($filterModel->getValue(), FILTER_VALIDATE_BOOLEAN), PDO::PARAM_BOOL);

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addGtFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $qb->andWhere(
                $qb->expr()->gt(
                    $fieldName,
                    sprintf(':%s', $parameterName)
                )
            )->setParameter($parameterName, sprintf('%s', $filterModel->getValue()));
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addGteFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $qb->andWhere(
                $qb->expr()->gte(
                    $fieldName,
                    sprintf(':%s', $parameterName)
                )
            )->setParameter($parameterName, sprintf('%s', $filterModel->getValue()));
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addLtFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $qb->andWhere(
                $qb->expr()->lt(
                    $fieldName,
                    sprintf(':%s', $parameterName)
                )
            )->setParameter($parameterName, sprintf('%s', $filterModel->getValue()));
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addLteFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $qb->andWhere(
                $qb->expr()->lte(
                    $fieldName,
                    sprintf(':%s', $parameterName)
                )
            )->setParameter($parameterName, sprintf('%s', $filterModel->getValue()));
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     *
     * @throws ServerRequestException
     */
    protected function addRadiusFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $values = explode(',', $filterModel->getValue());
        $fieldName = $this->createFieldName($alias, $filterModel->getField());

        if (3 !== count($values)) {
            throw new ServerRequestException(ServerException::ERROR_TYPE_INVALID_PARAMETER, 'Bad parameter', [$filterModel->getField()]);
        }

        list($y2, $x2, $distance) = $values;

        $qb->andWhere(sprintf('(ACOS( SIN(RADIANS(%s.latitude)) * SIN(RADIANS(%s)) + COS(RADIANS(%s.latitude)) * COS(RADIANS(%s)) * COS(RADIANS(%s - %s.longitude)) ) * 6371) < %s',
            $fieldName, $y2, $fieldName, $y2, $x2, $fieldName, $distance
        ));

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addLikeTextFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $x = $this->createFieldName($alias, $filterModel->getField());
            $y = sprintf(':%s', $parameterName);

            $qb->andWhere($this->ilike($x, $y));
            $qb->setParameter(
                $parameterName,
                sprintf(
                    $this->getLikePattern($filterModel->getOperator()),
                    $this->escapeLikeExpression($filterModel->getValue())
                )
            );
        }

        return $qb;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param QueryBuilder     $qb
     * @param string|null      $alias
     *
     * @return QueryBuilder
     */
    protected function addTextFieldToQuery(QueryFilterModel $filterModel, QueryBuilder $qb, $alias): QueryBuilder
    {
        $parameterName = $this->createParameterName($filterModel->getField());

        if (!is_null($filterModel->getValue())) {
            $x = $this->createFieldName($alias, $filterModel->getField());
            $y = sprintf(':%s', $parameterName);
            $qb->andWhere($this->ilike($x, $y))
                ->setParameter($parameterName, $filterModel->getValue());
        }

        return $qb;
    }

    /**
     * @param string $field
     *
     * @return string
     */
    private function createParameterName(string $field): string
    {
        return str_replace('.', '_', $field);
    }

    /**
     * @param string      $field
     * @param string|null $alias
     *
     * @return string
     */
    private function createFieldName($alias, string $field): string
    {
        if (null === $alias) {
            return $field;
        }

        return sprintf('%s.%s', $alias, $field);
    }

    /**
     * @param mixed $x
     * @param mixed $y
     *
     * @return Comparison
     */
    public function ilike($x, $y)
    {
        return new Comparison(
            new Func('lower', [$x]),
            'LIKE',
            new Func('lower', $y)
        );
    }

    /**
     * @param $pattern
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getLikePattern($pattern)
    {
        switch ($pattern) {
            case self::LIKE_TEXT_LIKE:
                return '%%%s%%';
            case self::LIKE_TEXT:
                return '%%%s';
            case self::TEXT_LIKE:
                return '%s%%';
        }
        throw new \Exception('Invalid Text pattern');
    }

    /**
     * @param $expression
     *
     * @return string
     */
    protected function escapeLikeExpression($expression)
    {
        return addcslashes($expression, '\_%');
    }
}