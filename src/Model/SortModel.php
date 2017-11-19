<?php

namespace CSC\Model;

/**
 * Class SortModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class SortModel
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
     * @return SortModel
     */
    public function setField(string $field): SortModel
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
     * @return SortModel
     */
    public function setDirection(string $direction): SortModel
    {
        $this->direction = $direction;

        return $this;
    }
}