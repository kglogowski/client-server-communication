<?php

namespace CSC\Component\Rest\Request\Checker;

use CSC\DependencyInjection\Configuration;
use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;

/**
 * Class InsertableChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class InsertableChecker extends AbstractFieldsChecker
{
    /**
     * {@inheritdoc}
     */
    protected function getFields(SimpleDataObjectInterface $dataObject): array
    {
        return $dataObject->getValue(DataObject::VALUE_INSERTABLE, []);
    }
}