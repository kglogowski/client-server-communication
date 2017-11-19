<?php

namespace CSC\Tests\Protocol\Rest\Server\DataObject;

use CSC\Protocol\Rest\Server\DataObject\AbstractRestSimpleDataObject;
use CSC\Tests\Model\ModelMock;

/**
 * Class RestDataObjectSimple
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDataObjectSimple extends AbstractRestSimpleDataObject
{
    /**
     * @return string
     */
    public function getEntityName(): string
    {
        return ModelMock::class;
    }
}