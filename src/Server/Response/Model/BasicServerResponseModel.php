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
     * @return mixed
     */
    public function getResult()
    {
        return $this;
    }
}