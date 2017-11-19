<?php

namespace CSC\Protocol\Rest\Server\Request\Model;

use CSC\Model\QueryFilterModel;
use CSC\Server\Exception\ServerException;
use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\Query;

/**
 * Class RestPagerRequestModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setPage(int $page): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setLimit(int $limit): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setSort(array $sort): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setFilter(array $filter): RestPagerRequestModel
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
     * @return array
     */
    public function getRoutingQuery(): array
    {
        $parameters = [];

        foreach ($this->getRoutingParameters() as $key => $parameter) {
            $key = Inflector::camelize($key);
            $parameters[$key] = $parameter;
        }

        return $parameters;
    }

    /**
     * @param array $routingParameters
     *
     * @return RestPagerRequestModel
     */
    public function setRoutingParameters(array $routingParameters): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setQuery(Query $query): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setMethodName(string $methodName): RestPagerRequestModel
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
     * @return RestPagerRequestModel
     */
    public function setEntityName(string $entityName): RestPagerRequestModel
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
            throw new ServerException(ServerException::ERROR_TYPE_INVALID_PARAMETER, 'Parameter does not exist', $key);
        }
    }
}