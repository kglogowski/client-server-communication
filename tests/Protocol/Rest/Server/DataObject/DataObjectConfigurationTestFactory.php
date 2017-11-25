<?php

namespace CSC\Tests\Protocol\Rest\Server\DataObject;

use CSC\Tests\Repository\AbstractTestRepository;

/**
 * Class DataObjectConfigurationTestFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DataObjectConfigurationTestFactory
{
    public static function createPager()
    {
        return [
            'CSC\Tests\Protocol\Rest\Server\DataObject\RestDataObjectPager' => [
                'methods' => [
                    AbstractTestRepository::TEST_METHOD_NAME => [
                        'filter' => ['id', 'name'],
                        'sort' => ['id']
                    ]
                ]
            ]
        ];
    }
}