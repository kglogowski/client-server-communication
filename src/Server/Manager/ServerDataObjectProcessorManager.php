<?php

namespace CSC\Server\Manager;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Request\Processor\ServerRequestProcessor;
use CSC\Server\Response\Processor\ServerResponseProcessor;

/**
 * Class ServerDataObjectProcessorManager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ServerDataObjectProcessorManager
{
    /**
     * @var ServerRequestProcessor
     */
    protected $requestProcessor;

    /**
     * @var ServerResponseProcessor
     */
    protected $responseProcessor;
    /**
     * ServerDataObjectProcessorManager constructor.
     *
     * @param ServerRequestProcessor  $requestProcessor
     * @param ServerResponseProcessor $responseProcessor
     */
    public function __construct(ServerRequestProcessor $requestProcessor, ServerResponseProcessor $responseProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->responseProcessor = $responseProcessor;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return mixed
     */
    public function process(DataObject $dataObject)
    {
        $responseModel = $this->requestProcessor->process($dataObject);

        return $this->responseProcessor->process($responseModel, $dataObject);
    }
}