<?php

namespace CSC\Server\Response\Model;

/**
 * Class AbstractServerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractServerResponseModel implements ServerResponseModel
{
    /**
     * @return ServerResponseModel
     */
    public function getResponse(): ServerResponseModel
    {
        return $this;
    }
}