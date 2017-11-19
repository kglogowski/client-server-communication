<?php

namespace CSC\Protocol\Rest\Server\DataObject;

/**
 * Class AbstractRestSimpleDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractRestSimpleDataObject extends AbstractRestDataObject implements RestSimpleDataObject
{
    /**
     * JSON formatted field list
     * Not required.
     *
     * @var string|null
     */
    protected $fields;

    /**
     * AbstractServerRestSimpleDataObject constructor.
     *
     * @param string|null $fields
     * @param array|null  $routingParameters
     */
    public function __construct(
        string $fields = null,
        array $routingParameters = null
    )
    {
        $this->fields = $fields;
        $this->routingParameters = $routingParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return [
            'fields' => $this->getFields(),
            'routingParameters' => $this->getRoutingParameters(),
            'httpMethod' => $this->getHttpMethod(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(string $fields = null): RestSimpleDataObject
    {
        $this->fields = $fields;

        return $this;
    }
}