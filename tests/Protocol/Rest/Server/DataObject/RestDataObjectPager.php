<?php

namespace CSC\Tests\Protocol\Rest\Server\DataObject;

use CSC\Protocol\Rest\Server\DataObject\AbstractRestPagerDataObject;
use CSC\Tests\Model\ModelMock;

/**
 * Class RestDataObjectPager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDataObjectPager extends AbstractRestPagerDataObject
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return ModelMock::class;
    }
}