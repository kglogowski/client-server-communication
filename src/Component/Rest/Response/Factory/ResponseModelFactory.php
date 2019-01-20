<?php

namespace CSC\Component\Rest\Response\Factory;

use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Interface ResponseModelFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ResponseModelFactory
{
    /**
     * @param object $object
     *
     * @return ServerResponseModel
     */
    public function create($object): ServerResponseModel;
}