<?php

namespace CSC\Component\Rest\Response\Model;

/**
 * Class ServerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ServerResponseModel
{
    /**
     * @return mixed
     */
    public function getResult();
}