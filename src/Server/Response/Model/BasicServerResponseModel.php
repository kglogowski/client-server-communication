<?php

namespace CSC\Server\Response\Model;

/**
 * Class AbstractServerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class BasicServerResponseModel implements ServerResponseModel
{
    /**
     * @return ServerResponseModel
     */
    public function getResponse(): ServerResponseModel
    {
        return $this;
    }
}