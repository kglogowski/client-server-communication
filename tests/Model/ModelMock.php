<?php

namespace CSC\Tests\Model;

use CSC\Server\Response\Model\BasicServerResponseModel;

/**
 * Class ModelMock
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ModelMock extends BasicServerResponseModel
{
    CONST
        DEFAULT_NAME = 'Random name',
        DEFAULT_ID = 1
    ;

    /**
     * @var int
     */
    protected $id = self::DEFAULT_ID;

    /**
     * @var string
     */
    protected $name = self::DEFAULT_NAME;

    /**
     * @param $id
     *
     * @return ModelMock
     */
    public function setId($id): ModelMock
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ModelMock
     */
    public function setName(string $name): ModelMock
    {
        $this->name = $name;

        return $this;
    }
}