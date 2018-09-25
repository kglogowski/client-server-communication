<?php

namespace CSC\Server\Checker;

use CSC\DependencyInjection\Configuration;

/**
 * Class InsertableChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class InsertableChecker extends AbstractFieldsCheckerSimpleDataObject
{
    /**
     * {@inheritdoc}
     */
    protected function getIndex(): string
    {
        return Configuration::SIMPLE_DATA_OBJECT_INSERTABLE_KEY;
    }
}