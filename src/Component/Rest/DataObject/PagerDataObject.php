<?php

namespace CSC\Server\DataObject;

/**
 * Class PagerDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerDataObject extends AbstractDataObject implements PagerDataObjectInterface
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
        ];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMethodName(): string
    {
        return $this->getRoutingValue(self::VALUE_METHOD_NAME);
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
    public function setPage(int $page): PagerDataObjectInterface
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
    public function setLimit(int $limit): PagerDataObjectInterface
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
    public function setSort(string $sort): PagerDataObjectInterface
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
    public function setFilter(string $filter): PagerDataObjectInterface
    {
        $this->filter = $filter;

        return $this;
    }
}