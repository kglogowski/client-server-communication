<?php

namespace CSC\Tests\Protocol\Rest\Server\Provider;

use CSC\Tests\Protocol\Rest\Server\DataObject\RestDataObjectPager;
use PHPUnit\Framework\TestCase;

/**
 * Class RestPagerQueryProviderTest
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryProviderTest extends TestCase
{
    /**
     * testPager
     */
    public function testPager()
    {
        $dataObject = new RestDataObjectPager();
        $dataObject->setMethodName('testMethod');
    }
}