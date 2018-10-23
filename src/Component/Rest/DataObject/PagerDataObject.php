<?php

namespace CSC\Server\DataObject;

/**
 * Interface PagerDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerDataObject extends DataObject
{
    /**
     * @return string
     */
    public function getMethodName(): string;

    /**
     * @param string $methodName
     *
     * @return PagerDataObject
     */
    public function setMethodName(string $methodName): PagerDataObject;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     *
     * @return PagerDataObject
     */
    public function setPage(int $page): PagerDataObject;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @param int $limit
     *
     * @return PagerDataObject
     */
    public function setLimit(int $limit): PagerDataObject;

    /**
     * @return string|null
     */
    public function getSort(): ?string;

    /**
     * @param string $sort
     *
     * @return PagerDataObject
     */
    public function setSort(string $sort): PagerDataObject;

    /**
     * @return string|null
     */
    public function getFilter(): ?string;

    /**
     * @param string $filter
     *
     * @return PagerDataObject
     */
    public function setFilter(string $filter): PagerDataObject;
}