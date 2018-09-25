<?php

namespace CSC\Server\DataObject;

use CSC\Component\Translate\TranslateDictionary;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Server\Response\Model\ServerResponseModel;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractDataObject implements DataObject
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
    public function getSupportedSerializationGroups(): array
    {
        $serializationGroups = $this->supportedSerializationGroups();
        $serializationGroups[] = self::ANY;
        $serializationGroups[] = self::NONE;

        return $serializationGroups;
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
    public function setSerializationGroups(array $serializationGroups): DataObject
    {
        $serializationGroups[] = self::ANY;

        $this->serializationGroups = $serializationGroups;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function supportedValidationGroups(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function supportedSerializationGroups(): array
    {
        return [];
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
    public function setRoutingParameters(array $routingParameters): DataObject
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