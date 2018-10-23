<?php

namespace CSC\Server\Response\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class AbstractServerResponseModel
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class BasicServerResponseModel implements ServerResponseModel
{
    /**
     * @var object
     *
     * @JMS\Expose
     * @JMS\Groups({"Any"})
     */
    protected $result;

    /**
     * SimpleDataResponseModel constructor.
     *
     * @param mixed $result
     */
    public function __construct($result = null)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}