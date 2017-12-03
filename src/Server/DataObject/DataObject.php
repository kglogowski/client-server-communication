<?php

namespace CSC\Server\DataObject;

use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface DataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface DataObject
{
    /**
     * To check is async response
     *
     * @return bool
     */
    public function isAsync(): bool;

    /**
     * @param bool $async
     *
     * @return DataObject
     */
    public function setAsync(bool $async): DataObject;

    /**
     * @param ServerResponseModel $responseModel
     *
     * @return DataObject
     */
    public function setResponseModel(ServerResponseModel $responseModel): DataObject;

    /**
     * @return ServerResponseModel
     */
    public function getResponseModel(): ?ServerResponseModel;

    /**
     * @return string[]
     */
    public function getValidationGroups(): array;

    /**
     * @param array $validationGroups
     *
     * @return DataObject
     */
    public function setValidationGroups(array $validationGroups): DataObject;

    /**
     * @param string $voter
     *
     * @return DataObject
     */
    public function addEntityVoter(string $voter): DataObject;

    /**
     * @return array
     */
    public function getEntityVoters(): array;
}