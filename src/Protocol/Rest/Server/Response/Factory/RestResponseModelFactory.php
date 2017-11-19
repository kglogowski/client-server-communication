<?php

namespace CSC\Protocol\Rest\Server\Response\Factory;

use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface RestResponseModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface RestResponseModelFactory
{
    /**
     * @param object $object
     *
     * @return ServerResponseModel
     */
    public function create($object): ServerResponseModel;
}