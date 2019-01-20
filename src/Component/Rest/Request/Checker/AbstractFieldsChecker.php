<?php

namespace CSC\Server\Checker;

use CSC\Server\DataObject\SimpleDataObjectInterface;
use CSC\Server\Exception\ServerException;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Component\Translate\TranslateDictionary;

/**
 * Class AbstractFieldsChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractFieldsChecker implements FieldsChecker
{
    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return bool
     *
     * @throws ServerRequestException
     */
    public function check(SimpleDataObjectInterface $dataObject): bool
    {
        $availableFields = $this->getFields($dataObject);

        if (0 !== count($availableFields)) {
            $fields = json_decode($dataObject->getFields(), true) ?? [];

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
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return array
     */
    abstract protected function getFields(SimpleDataObjectInterface $dataObject): array;
}