<?php

namespace CSC\Server\Checker;

use CSC\Server\DataObject\SimpleDataObject;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;

/**
 * Class AbstractFieldsCheckerSimpleDataObject
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractFieldsCheckerSimpleDataObject implements FieldsCheckerSimpleDataObjectInterface
{
    /**
     * @var array
     */
    protected $simpleDataObjectConfiguration;

    /**
     * PatchUpdatableChecker constructor.
     *
     * @param array $simpleDataObjectConfiguration
     */
    public function __construct(array $simpleDataObjectConfiguration)
    {
        $this->simpleDataObjectConfiguration = $simpleDataObjectConfiguration;
    }

    /**
     * @param SimpleDataObject $dataObject
     *
     * @return bool
     *
     * @throws ServerRequestException
     */
    public function check(SimpleDataObject $dataObject): bool
    {
        $dataObjectClass = get_class($dataObject);

        if (array_key_exists($dataObjectClass, $this->simpleDataObjectConfiguration)) {
            $fields = json_decode($dataObject->getFields(), true) ?? [];
            $availableFields = $this->simpleDataObjectConfiguration[$dataObjectClass][$this->getIndex()];

            if (0 < count($availableFields)) {
                $transmittedFields = array_keys($fields);

                $redundantFields = array_diff($transmittedFields, $availableFields);

                if (0 !== count($redundantFields)) {
                    throw new ServerRequestException(
                        ServerException::ERROR_TYPE_INVALID_PARAMETER,
                        TranslateDictionary::KEY_ELEMENT_UNSUPPORTED_PARAMETERS,
                        array_values($redundantFields)
                    );
                }
            }
        }

        return true;
    }

    /**
     * @return string
     */
    abstract protected function getIndex(): string;
}