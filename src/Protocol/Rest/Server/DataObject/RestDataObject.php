<?php

namespace CSC\Protocol\Rest\Server\DataObject;

use CSC\ORM\EntityNameAware;
use CSC\Server\DataObject\DataObject;

/**
 * Class RestDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestDataObject extends DataObject, EntityNameAware
{
    /**
     * Basic groups to validation and serialization
     */
    const
        POST    = 'Post',
        PATCH   = 'Patch',
        GET     = 'Get',
        DELETE  = 'Delete',
        ANY     = 'Any',
        NONE    = 'None'
    ;

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