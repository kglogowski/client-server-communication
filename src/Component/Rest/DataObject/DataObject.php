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
    const ANY = 'Any';

    /**
     * Key routing parameters Common
     */
    const
        VALUE_ENTITY_NAME = 'entityName',
        VALUE_SERIALIZATION = 'serialization',
        VALUE_VALIDATION = 'validation',
        VALUE_VOTER = 'voter',
        VALUE_REQUEST_PROCESSOR = 'requestProcessor',
        VALUE_RESPONSE_PROCESSOR = 'responseProcessor'
    ;

    /**
     * Key routing parameters Simple
     */
    const
        VALUE_INSERTABLE = 'insertable',
        VALUE_UPDATABLE = 'updatable'
    ;

    /**
     * Key routing parameters Pager
     */
    const
        VALUE_METHOD_NAME = 'methodName',
        VALUE_AVAILABLE_FILTER = 'availableFilter',
        VALUE_AVAILABLE_SORT = 'availableSort'
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
     * @return array
     */
    public function getParameters(): array;

    /**
     * @return bool
     */
    public function hasParameters(): bool;

    /**
     * @return string
     */
    public function getHttpMethod(): string;

    /**
     * @param string $httpMethod
     */
    public function setHttpMethod(string $httpMethod);

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
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getValue(string $key, $default = null);

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

    /**
     * @return array
     */
    public function getValidationGroups(): array;

    /**
     * @return array
     */
    public function getSerializationGroups(): array;

    /**
     * @return array
     */
    public function getVoters(): array;

    /**
     * @return string|null
     */
    public function getRequestProcessor(): ?string;

    /**
     * @return string|null
     */
    public function getResponseProcessor(): ?string;

    /**
     * @return array
     */
    public function getProtectedParameters(): array;
}