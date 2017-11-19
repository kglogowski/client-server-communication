<?php

namespace CSC\Protocol\Rest\Server\Request\Model;

/**
 * Class PagerSortModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerSortModel
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $direction;

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return PagerSortModel
     */
    public function setField(string $field): PagerSortModel
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @return PagerSortModel
     */
    public function setDirection(string $direction): PagerSortModel
    {
        $this->direction = $direction;

        return $this;
    }
}