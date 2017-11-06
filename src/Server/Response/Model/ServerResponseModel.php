<?php

namespace CSC\Server\Response\Model;

/**
 * Class ServerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerResponseModel
{
    /**
     * @return ServerResponseModel
     */
    public function getResponse(): ServerResponseModel;
}