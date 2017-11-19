<?php

namespace CSC\Protocol\Rest\Server\Request\Model;

/**
 * Class PagerPaginatorModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerPaginatorModel
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var array
     */
    protected $items;

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
     * @return PagerPaginatorModel
     */
    public function setPage(int $page): PagerPaginatorModel
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     *
     * @return PagerPaginatorModel
     */
    public function setPerPage(int $perPage): PagerPaginatorModel
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return PagerPaginatorModel
     */
    public function setCount(int $count): PagerPaginatorModel
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return PagerPaginatorModel
     */
    public function setItems(array $items): PagerPaginatorModel
    {
        $this->items = $items;

        return $this;
    }
}