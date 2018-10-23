<?php

namespace CSC\Server\Response\Factory;

use CSC\Server\Response\Model\BasicServerResponseModel;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class DefaultResponseModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DefaultResponseModelFactory implements ResponseModelFactory
{
    /**
     * {@inheritdoc}
     */
    public function create($object): ServerResponseModel
    {
        if (is_object($object) && $object instanceof ServerResponseModel) {
            return $object;
        }

        return (new BasicServerResponseModel($object));
    }
}