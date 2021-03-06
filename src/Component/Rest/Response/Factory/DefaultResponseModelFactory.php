<?php

namespace CSC\Component\Rest\Response\Factory;

use CSC\Component\Rest\Response\Model\BasicServerResponseModel;
use CSC\Component\Rest\Response\Model\ServerResponseModel;

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