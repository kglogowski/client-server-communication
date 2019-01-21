<?php

namespace CSC\Component\Rest\DataObject;

use CSC\Translate\TranslateDictionary;
use CSC\Exception\ServerException;
use CSC\Exception\ServerRequestException;
use CSC\Component\Rest\Response\Model\ServerResponseModel;
use Doctrine\Common\Inflector\Inflector;

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
    protected $voters = [];

    /**
     * @var string|null
     */
    protected $entityName;


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
    public function getRoutingParameters(): array
    {
        return $this->routingParameters;
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getRoutingParameter(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return [$key => $this->routingParameters[$key]];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function getRoutingValue(string $key)
    {
        $this->checkRoutingParameterExists($key);

        return $this->routingParameters[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(string $key, $default = null)
    {
        if (!array_key_exists($key, $this->routingParameters)) {
            return $default;
        }

        return $this->routingParameters[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutingQuery(): array
    {
        $parameters = [];

        foreach ($this->getRoutingParameters() as $key => $parameter) {
            if (in_array($key, $this->getProtectedParameters(), true)) {
                continue;
            }

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
     * @return string
     * @throws \Exception
     */
    public function getEntityName(): ?string
    {
        return $this->getRoutingValue(DataObject::VALUE_ENTITY_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getSerializationGroups(): array
    {
        return array_merge($this->getValue(DataObject::VALUE_SERIALIZATION, []), [self::ANY]);
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationGroups(): array
    {
        return $this->getValue(DataObject::VALUE_SERIALIZATION, []);
    }

    /**
     * {@inheritdoc}
     */
    public function getVoters(): array
    {
        return $this->getValue(DataObject::VALUE_VOTER, []);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestProcessor(): ?string
    {
        return $this->getValue(DataObject::VALUE_REQUEST_PROCESSOR);
    }

    /**
     * {@inheritdoc}
     */
    public function getResponseProcessor(): ?string
    {
        return $this->getValue(DataObject::VALUE_RESPONSE_PROCESSOR);
    }

    /**
     * @return array
     */
    public function getProtectedParameters(): array
    {
        return [
            self::VALUE_ENTITY_NAME,
            self::VALUE_SERIALIZATION,
            self::VALUE_VALIDATION,
            self::VALUE_VOTER,
            self::VALUE_INSERTABLE,
            self::VALUE_UPDATABLE,
            self::VALUE_METHOD_NAME,
            self::VALUE_AVAILABLE_FILTER,
            self::VALUE_AVAILABLE_SORT,
            self::VALUE_REQUEST_PROCESSOR,
            self::VALUE_RESPONSE_PROCESSOR,
        ];
    }
}