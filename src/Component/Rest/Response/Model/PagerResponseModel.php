<?php

namespace CSC\Component\Rest\Response\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class PagerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class PagerResponseModel implements ServerResponseModel
{
    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $href;

    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $page;

    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $perPage;

    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $count;

    /**
     * @var array
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $items = [];

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return [];
    }

    /**
     * @return string|null
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return PagerResponseModel
     */
    public function setHref(string $href): PagerResponseModel
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return PagerResponseModel
     */
    public function setPage(int $page): PagerResponseModel
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     *
     * @return PagerResponseModel
     */
    public function setPerPage(int $perPage): PagerResponseModel
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return PagerResponseModel
     */
    public function setCount(int $count): PagerResponseModel
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
     * @return PagerResponseModel
     */
    public function setItems(array $items): PagerResponseModel
    {
        $this->items = $items;

        return $this;
    }
}