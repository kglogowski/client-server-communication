<?php

namespace CSC\Component\Rest\DataObject;

/**
 * Class SimpleDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class SimpleDataObject extends AbstractDataObject implements SimpleDataObjectInterface
{
    /**
     * JSON formatted field list
     * Not required.
     *
     * @var string|null
     */
    protected $fields;

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
    public function setFields(string $fields = null): SimpleDataObjectInterface
    {
        $this->fields = $fields;

        return $this;
    }
}