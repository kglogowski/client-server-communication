<?php

namespace CSC\Model;

use CSC\Server\Exception\ServerException;
use CSC\Component\Translate\TranslateDictionary;
use Doctrine\ORM\Query;

/**
 * Class PagerRequestModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerRequestModel
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var SortModel[]
     */
    private $sort;

    /**
     * @var QueryFilterModel[]
     */
    private $filter;

    /**
     * @var array
     */
    private $routingParameters;

    /**
     * @var Query
     */
    private $query;

    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return PagerRequestModel
     */
    public function setPage(int $page): PagerRequestModel
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return PagerRequestModel
     */
    public function setLimit(int $limit): PagerRequestModel
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return SortModel[]
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * @param SortModel[] $sort
     *
     * @return PagerRequestModel
     */
    public function setSort(array $sort): PagerRequestModel
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return QueryFilterModel[]
     */
    public function getFilter(): array
    {
        return $this->filter;
    }

    /**
     * @param QueryFilterModel[] $filter
     *
     * @return PagerRequestModel
     */
    public function setFilter(array $filter): PagerRequestModel
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasFilter(string $key): bool
    {
        foreach ($this->filter as $filterModel) {
            if ($key === $filterModel->getField()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRoutingParameters(): array
    {
        return $this->routingParameters;
    }

    /**
     * @param string $key
     *
     * @return array
     *
     * @throws ServerException
     */
    public function getRoutingParameter(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return [$key => $this->routingParameters[$key]];
    }

    /**
     * @param string $key
     *
     * @return string|array|null
     *
     * @throws ServerException
     */
    public function getRoutingValue(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return $this->routingParameters[$key];
    }

    /**
     * @param array $routingParameters
     *
     * @return PagerRequestModel
     */
    public function setRoutingParameters(array $routingParameters): PagerRequestModel
    {
        $this->routingParameters = $routingParameters;

        return $this;
    }

    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        return $this->query;
    }

    /**
     * @param Query $query
     *
     * @return PagerRequestModel
     */
    public function setQuery(Query $query): PagerRequestModel
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return PagerRequestModel
     */
    public function setMethodName(string $methodName): PagerRequestModel
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     *
     * @return PagerRequestModel
     */
    public function setEntityName(string $entityName): PagerRequestModel
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws ServerException
     */
    private function checkRoutingParameterExists(string $key)
    {
        if (!array_key_exists($key, $this->routingParameters)) {
            throw new ServerException(
                ServerException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_PARAMETER_DOES_NOT_EXIST,
                $key
            );
        }
    }
}