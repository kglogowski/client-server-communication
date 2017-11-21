<?php

namespace CSC\Protocol\Rest\Builder;

use CSC\Checker\QueryParameterChecker;
use CSC\Builder\QueryFilterBuilder;
use CSC\Model\SortModel;
use CSC\Model\QueryFilterModel;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class RestPagerQueryBuilder
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryBuilder
{
    const UNLIMITED_VALUE = '-1';

    /**
     * @var QueryFilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var QueryParameterChecker
     */
    protected $checker;

    /**
     * PagerOrderedQueryBuilder constructor.
     *
     * @param QueryFilterBuilder    $filterBuilder
     * @param QueryParameterChecker $checker
     */
    public function __construct(QueryFilterBuilder $filterBuilder, QueryParameterChecker $checker)
    {
        $this->filterBuilder = $filterBuilder;
        $this->checker = $checker;
    }

    /**
     * @var array
     */
    protected $supportFilterParameters = [];

    /**
     * @var array
     */
    protected $supportSortParameters = [];

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var int $page
     */
    protected $page;

    /**
     * @var int $limit
     */
    protected $limit;

    /**
     * @param array $supportFilterParameters
     *
     * @return RestPagerQueryBuilder
     */
    public function setSupportFilterParameters(array $supportFilterParameters): RestPagerQueryBuilder
    {
        $this->supportFilterParameters = $supportFilterParameters;

        return $this;
    }

    /**
     * @param array $supportSortParameters
     *
     * @return RestPagerQueryBuilder
     */
    public function setSupportSortParameters(array $supportSortParameters): RestPagerQueryBuilder
    {
        $this->supportSortParameters = $supportSortParameters;

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return RestPagerQueryBuilder
     */
    public function setQueryBuilder(QueryBuilder $queryBuilder): RestPagerQueryBuilder
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * @return QueryBuilder|null
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param int $page
     *
     * @return RestPagerQueryBuilder
     */
    public function setPage(int $page): RestPagerQueryBuilder
    {
        $this->page = $page;

        return $this;
    }
    /**
     * @param int $limit
     *
     * @return RestPagerQueryBuilder
     */
    public function setLimit(int $limit): RestPagerQueryBuilder
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param QueryFilterModel[] $filterModels
     * @param string|null        $alias
     *
     * @return RestPagerQueryBuilder
     */
    public function addFilters(array $filterModels, $alias = null): RestPagerQueryBuilder
    {
        foreach ($filterModels as $filterModel) {
            $this->addFilter($filterModel, $alias);
        }

        return $this;
    }

    /**
     * @param QueryFilterModel $filterModel
     * @param string|null      $alias
     *
     * @return RestPagerQueryBuilder
     */
    public function addFilter(QueryFilterModel $filterModel, $alias = null): RestPagerQueryBuilder
    {
        $this->checker->checkFilterParameter($filterModel, $this->supportFilterParameters);
        $this->filterBuilder->modernize($this->queryBuilder, $filterModel, $alias);

        return $this;
    }

    /**
     * @param SortModel[] $sortModels
     * @param string|null $alias
     *
     * @return RestPagerQueryBuilder
     */
    public function addSorts(array $sortModels, $alias = null): RestPagerQueryBuilder
    {
        foreach ($sortModels as $sortModel) {
            $this->addSort($sortModel, $alias);
        }

        return $this;
    }

    /**
     * @param SortModel   $sortModel
     * @param string|null $alias
     *
     * @return RestPagerQueryBuilder
     */
    public function addSort(SortModel $sortModel, $alias = null): RestPagerQueryBuilder
    {
        $this->checker->checkSortParameter($sortModel, $this->supportSortParameters);
        $sortColumn = Inflector::camelize($sortModel->getField());

        if (null !== $alias) {
            $sortColumn = sprintf('%s.%s', $alias, $sortColumn);
        }

        $this->getQueryBuilder()->addOrderBy($sortColumn, $sortModel->getDirection());

        return $this;
    }

    /**
     * @return Query
     */
    public function getResult(): Query
    {
        if (null !== $this->page && null !== $this->limit && !$this->isUnlimited()) {
            $firstResult = ($this->page * $this->limit) - $this->limit;

            $this->getQueryBuilder()->setFirstResult($firstResult);
            $this->getQueryBuilder()->setMaxResults($this->limit);
        }

        return $this->getQueryBuilder()->getQuery();
    }

    /**
     * @return bool
     */
    public function isUnlimited(): bool
    {
        return self::UNLIMITED_VALUE === (string) $this->limit;
    }
}