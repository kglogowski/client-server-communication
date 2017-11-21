<?php

namespace CSC\Protocol\Rest\Server\Response\Factory;

use CSC\Server\Response\Model\BasicServerResponseModel;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class RestDefaultResponseModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDefaultResponseModelFactory implements RestResponseModelFactory
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