<?php

namespace CSC\Model;

/**
 * Class QueryFilterModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class QueryFilterModel
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var string
     */
    protected $value;

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
     * @return QueryFilterModel
     */
    public function setField(string $field): QueryFilterModel
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     *
     * @return QueryFilterModel
     */
    public function setOperator(string $operator): QueryFilterModel
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return QueryFilterModel
     */
    public function setValue(string $value): QueryFilterModel
    {
        $this->value = $value;

        return $this;
    }
}