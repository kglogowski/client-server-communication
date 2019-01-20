<?php

namespace CSC\Server\DataObject;

/**
 * Interface PagerDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerDataObjectInterface extends DataObject
{
    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     *
     * @return PagerDataObjectInterface
     */
    public function setPage(int $page): PagerDataObjectInterface;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @param int $limit
     *
     * @return PagerDataObjectInterface
     */
    public function setLimit(int $limit): PagerDataObjectInterface;

    /**
     * @return string|null
     */
    public function getSort(): ?string;

    /**
     * @param string $sort
     *
     * @return PagerDataObjectInterface
     */
    public function setSort(string $sort): PagerDataObjectInterface;

    /**
     * @return string|null
     */
    public function getFilter(): ?string;

    /**
     * @param string $filter
     *
     * @return PagerDataObjectInterface
     */
    public function setFilter(string $filter): PagerDataObjectInterface;

    /**
     * @return string
     */
    public function getMethodName(): string;
}