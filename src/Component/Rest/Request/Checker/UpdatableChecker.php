<?php

namespace CSC\Component\Rest\Request\Checker;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;

/**
 * Class UpdatableChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class UpdatableChecker extends AbstractFieldsChecker
{
    /**
     * {@inheritdoc}
     */
    protected function getFields(SimpleDataObjectInterface $dataObject): array
    {
        return $dataObject->getValue(DataObject::VALUE_UPDATABLE, []);
    }
}