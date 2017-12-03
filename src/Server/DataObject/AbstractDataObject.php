<?php

namespace CSC\Server\DataObject;

use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class AbstractDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractDataObject implements DataObject
{
    /**
     * @var ServerResponseModel|null
     */
    protected $responseModel;

    /**
     * @var bool
     */
    protected $async = false;

    /**
     * @var array
     */
    protected $validationGroups = [];

    /**
     * @var array
     */
    protected $voters = [];

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->async;
    }

    /**
     * @param bool $async
     *
     * @return DataObject
     */
    public function setAsync(bool $async): DataObject
    {
        $this->async = $async;

        return $this;
    }

    /**
     * @return ServerResponseModel|null
     */
    public function getResponseModel(): ?ServerResponseModel
    {
        return $this->responseModel;
    }

    /**
     * @param ServerResponseModel $responseModel
     *
     * @return DataObject
     */
    public function setResponseModel(ServerResponseModel $responseModel): DataObject
    {
        $this->responseModel = $responseModel;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationGroups(): array
    {
        return $this->validationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function setValidationGroups(array $validationGroups): DataObject
    {
        $this->validationGroups = $validationGroups;

        return $this;
    }

    /**
     * @param string $validationGroup
     *
     * @return DataObject
     */
    public function addValidationGroup(string $validationGroup): DataObject
    {
        $this->validationGroups[] = $validationGroup;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addVoter(string $voter): DataObject
    {
        $this->voters[] = $voter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVoters(): array
    {
        return $this->voters;
    }
}