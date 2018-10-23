<?php

namespace CSC\Server\Checker;

use CSC\DependencyInjection\Configuration;

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
    protected function getIndex(): string
    {
        return Configuration::SIMPLE_DATA_OBJECT_UPDATABLE_KEY;
    }
}