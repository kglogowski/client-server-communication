<?php

namespace CSC\Server\Protocol\Rest\DataObject;

use CSC\Server\DataObject\DataObject;

/**
 * Class RestDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestDataObject extends DataObject
{    /**
 * Basic groups to validation and serialization
 */
    const
        POST    = 'Post',
        PATCH   = 'Patch',
        GET     = 'Get',
        DELETE  = 'Delete'
    ;

    /**
     * Default serialization group
     */
    const SERIALIZED_GROUP_ANY = 'Any';
    const SERIALIZED_GROUP_NONE = 'None';

    /**
     * @return array|null
     */
    public function getParameters(): ?array;

    /**
     * @return bool
     */
    public function hasParameters(): bool;

    /**
     * @return array|null
     */
    public function getValidationGroups(): ?array;

    /**
     * @param array $validationGroups
     *
     * @return RestDataObject
     */
    public function setValidationGroups(array $validationGroups): RestDataObject;

    /**
     * @return array|null
     */
    public function getSerializationGroups(): ?array;

    /**
     * @param array $serializationGroups
     *
     * @return RestDataObject
     */
    public function setSerializationGroups(array $serializationGroups): RestDataObject;

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
     * @return RestDataObject
     */
    public function setRoutingParameters(array $routingParameters): RestDataObject;
}