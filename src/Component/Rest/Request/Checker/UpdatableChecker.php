<?php

namespace CSC\Component\Rest\Request\Checker;

use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\SimpleDataObjectInterface;

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