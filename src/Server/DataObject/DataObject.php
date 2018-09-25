<?php

namespace CSC\Server\DataObject;

use CSC\Model\Interfaces\EntityNameAware;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface DataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface DataObject extends EntityNameAware
{
    /**
     * Basic groups to validation and serialization
     */
    const
        POST    = 'Post',
        PATCH   = 'Patch',
        PUT     = 'Put',
        GET     = 'Get',
        DELETE  = 'Delete',
        ANY     = 'Any',
        NONE    = 'None'
    ;

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
    public function addVoter(string $voter): DataObject;

    /**
     * @return array
     */
    public function getVoters(): array;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @return bool
     */
    public function hasParameters(): bool;

    /**
     * @return array
     */
    public function getSerializationGroups(): array;

    /**
     * @param array $serializationGroups
     *
     * @return DataObject
     */
    public function setSerializationGroups(array $serializationGroups): DataObject;

    /**
     * @return string[]
     */
    public function supportedValidationGroups(): array;

    /**
     * @return string[]
     */
    public function supportedSerializationGroups(): array;

    /**
     * @return string[]
     */
    public function getSupportedSerializationGroups(): array;

    /**
     * @return string
     */
    public function getHttpMethod(): string;

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod(string $httpMethod);

    /**
     * Returns array of allowed HTTP request methods
     *
     * @return string[]
     */
    public function supportedHttpMethods(): array;

    /**
     * @return array
     */
    public function getRoutingParameters(): array;

    /**
     * @param string $key
     *
     * @return array
     */
    public function getRoutingParameter(string $key);

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function getRoutingValue(string $key);

    /**
     * @return array
     */
    public function getRoutingQuery(): array;

    /**
     * @param array|null $routingParameters
     *
     * @return DataObject
     */
    public function setRoutingParameters(array $routingParameters): DataObject;
}