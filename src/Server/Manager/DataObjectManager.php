<?php

namespace CSC\Server\Manager;

use CSC\Server\DataObject\DataObject;
use CSC\Server\Request\Processor\RequestProcessor;
use CSC\Server\Response\Processor\ServerResponseProcessor;
use FOS\RestBundle\View\View;

/**
 * Class DataObjectManager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class DataObjectManager
{
    /**
     * @var RequestProcessor
     */
    protected $requestProcessor;

    /**
     * @var ServerResponseProcessor
     */
    protected $responseProcessor;

    /**
     * DataObjectManager constructor.
     *
     * @param RequestProcessor    $requestProcessor
     * @param ServerResponseProcessor $responseProcessor
     */
    public function __construct(RequestProcessor $requestProcessor, ServerResponseProcessor $responseProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->responseProcessor = $responseProcessor;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return View
     */
    public function process(DataObject $dataObject): View
    {
        $dataObject = $this->requestProcessor->process($dataObject);

        return $this->responseProcessor->process($dataObject);
    }

    /**
     * @return RequestProcessor
     */
    public function getRequestProcessor(): RequestProcessor
    {
        return $this->requestProcessor;
    }

    /**
     * @param RequestProcessor $requestProcessor
     */
    public function setRequestProcessor(RequestProcessor $requestProcessor)
    {
        $this->requestProcessor = $requestProcessor;
    }

    /**
     * @return ServerResponseProcessor
     */
    public function getResponseProcessor(): ServerResponseProcessor
    {
        return $this->responseProcessor;
    }

    /**
     * @param ServerResponseProcessor $responseProcessor
     */
    public function setResponseProcessor(ServerResponseProcessor $responseProcessor)
    {
        $this->responseProcessor = $responseProcessor;
    }
}