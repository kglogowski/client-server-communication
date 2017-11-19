<?php

namespace CSC\Model;

/**
 * Class PaginatorModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PaginatorModel
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
     * @return PaginatorModel
     */
    public function setPage(int $page): PaginatorModel
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
     * @return PaginatorModel
     */
    public function setPerPage(int $perPage): PaginatorModel
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
     * @return PaginatorModel
     */
    public function setCount(int $count): PaginatorModel
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
     * @return PaginatorModel
     */
    public function setItems(array $items): PaginatorModel
    {
        $this->items = $items;

        return $this;
    }
}