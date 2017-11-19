<?php

namespace CSC\Protocol\Rest\Server\DataObject;

/**
 * Interface RestPagerDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestPagerDataObject extends RestDataObject
{
    /**
     * @return string
     */
    public function getMethodName(): string;

    /**
     * @param string $methodName
     *
     * @return RestPagerDataObject
     */
    public function setMethodName(string $methodName): RestPagerDataObject;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @param int $page
     *
     * @return RestPagerDataObject
     */
    public function setPage(int $page): RestPagerDataObject;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @param int $limit
     *
     * @return RestPagerDataObject
     */
    public function setLimit(int $limit): RestPagerDataObject;

    /**
     * @return string|null
     */
    public function getSort(): ?string;

    /**
     * @param string $sort
     *
     * @return RestPagerDataObject
     */
    public function setSort(string $sort): RestPagerDataObject;

    /**
     * @return string|null
     */
    public function getFilter(): ?string;

    /**
     * @param string $filter
     *
     * @return RestPagerDataObject
     */
    public function setFilter(string $filter): RestPagerDataObject;
}