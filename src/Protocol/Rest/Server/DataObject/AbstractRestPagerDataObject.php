<?php

namespace CSC\Protocol\Rest\Server\DataObject;

/**
 * Class AbstractRestPagerDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractRestPagerDataObject extends AbstractRestDataObject implements RestPagerDataObject
{
    /**
     * @var int
     */
    private $page;

    /**
     */
    private $limit;

    /**
     * @var string|null
     */
    private $sort;

    /**
     * @var string|null
     */
    private $filter;

    /**
     * @var string
     */
    private $methodName;

    /**
     * PagerOrderedDataObject constructor.
     *
     * @param int    $page
     * @param int    $limit
     * @param string $sort
     * @param string $filter
     * @param array  $routingParameters
     */
    public function __construct(
        int $page = null,
        int $limit = null,
        string $sort = null,
        string $filter = null,
        array $routingParameters = null
    )
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->sort = $sort;
        $this->filter = $filter;
        $this->routingParameters = $routingParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return [
            'page' => $this->getPage(),
            'limit' => $this->getLimit(),
            'sort' => $this->getSort(),
            'filter' => $this->getFilter(),
            'routingParameters' => $this->getRoutingParameters(),
            'methodName' => $this->getMethodName(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     *
     * @return RestPagerDataObject
     */
    public function setMethodName(string $methodName): RestPagerDataObject
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * {@inheritdoc}
     */
    public function setPage(int $page): RestPagerDataObject
    {
        $this->page = $page;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setLimit(int $limit): RestPagerDataObject
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * {@inheritdoc}
     */
    public function setSort(string $sort): RestPagerDataObject
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilter(): ?string
    {
        return $this->filter;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilter(string $filter): RestPagerDataObject
    {
        $this->filter = $filter;

        return $this;
    }
}