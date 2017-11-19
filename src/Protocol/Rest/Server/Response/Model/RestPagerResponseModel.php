<?php

namespace CSC\Protocol\Rest\Server\Response\Model;

use CSC\Server\Response\Model\ServerResponseModel;
use JMS\Serializer\Annotation as JMS;

/**
 * Class RestPagerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class RestPagerResponseModel implements ServerResponseModel
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
     * @return RestPagerResponseModel
     */
    public function setHref(string $href): RestPagerResponseModel
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
     * @return RestPagerResponseModel
     */
    public function setPage(int $page): RestPagerResponseModel
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
     * @return RestPagerResponseModel
     */
    public function setPerPage(int $perPage): RestPagerResponseModel
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
     * @return RestPagerResponseModel
     */
    public function setCount(int $count): RestPagerResponseModel
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
     * @return RestPagerResponseModel
     */
    public function setItems(array $items): RestPagerResponseModel
    {
        $this->items = $items;

        return $this;
    }
}