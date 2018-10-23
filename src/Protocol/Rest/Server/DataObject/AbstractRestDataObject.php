<?php

namespace CSC\Protocol\Rest\Server\DataObject;

use CSC\Server\DataObject\AbstractDataObject;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;
use Doctrine\Common\Util\Inflector;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRestDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractRestDataObject extends AbstractDataObject implements RestDataObject
{
    /**
     * HTTP request method name. [GET/POST/PATCH/DELETE]
     * Required.
     *
     * @var string
     */
    protected $httpMethod;

    /**
     * @var array
     */
    protected $serializationGroups = [];

    /**
     * @var array|null
     */
    protected $routingParameters;

    /**
     * {@inheritdoc}
     */
    public function hasParameters(): bool
    {
        $parameters = $this->getParameters();

        return is_array($parameters) && 0 !== count($parameters);
    }

    /**
     * {@inheritdoc}
     */
    final public function getHttpMethod(): string
    {
        return strtoupper($this->httpMethod);
    }

    /**
     * {@inheritdoc}
     */
    public function setHttpMethod(string $httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function supportedHttpMethods(): array
    {
        return [
            Request::METHOD_GET,
            Request::METHOD_POST,
            Request::METHOD_PATCH,
            Request::METHOD_PUT,
            Request::METHOD_DELETE,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializationGroups(): array
    {
        return $this->serializationGroups;
    }

    /**
     * {@inheritdoc}
     */
    public function setSerializationGroups(array $serializationGroups): RestDataObject
    {
        $serializationGroups[] = self::ANY;

        $this->serializationGroups = $serializationGroups;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutingParameters(): array
    {
        return $this->routingParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutingParameter(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return [$key => $this->routingParameters[$key]];
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutingValue(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return $this->routingParameters[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutingQuery(): array
    {
        $parameters = [];

        foreach ($this->getRoutingParameters() as $key => $parameter) {
            $key = Inflector::camelize($key);
            $parameters[$key] = $parameter;
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoutingParameters(array $routingParameters): RestDataObject
    {
        $this->routingParameters = $routingParameters;

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws ServerRequestException
     */
    private function checkRoutingParameterExists(string $key)
    {
        if (!array_key_exists($key, $this->routingParameters)) {
            throw new ServerRequestException(
                ServerException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_PARAMETER_DOES_NOT_EXIST,
                $key
            );
        }
    }
}