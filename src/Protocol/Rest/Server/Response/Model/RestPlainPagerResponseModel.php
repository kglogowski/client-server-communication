<?php

namespace CSC\Protocol\Rest\Server\Response\Model;

use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class RestPlainPagerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPlainPagerResponseModel implements ServerResponseModel
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
     * @return RestPlainPagerResponseModel
     */
    public function setHref(string $href): RestPlainPagerResponseModel
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
     * @return RestPlainPagerResponseModel
     */
    public function setItems($items): RestPlainPagerResponseModel
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