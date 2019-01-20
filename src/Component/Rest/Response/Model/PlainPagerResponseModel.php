<?php

namespace CSC\Component\Rest\Response\Model;

/**
 * Class PlainPagerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PlainPagerResponseModel implements ServerResponseModel
{
    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $href;

    /**
     * @var array
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $items = [];

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return PlainPagerResponseModel
     */
    public function setHref(string $href): PlainPagerResponseModel
    {
        $this->href = $href;

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
     * @return PlainPagerResponseModel
     */
    public function setItems($items): PlainPagerResponseModel
    {
        $this->items = $items;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return [];
    }
}