<?php

namespace CSC\Protocol\Rest\Server\Manager;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\Request\Processor\RestRequestProcessor;
use CSC\Server\Response\Processor\ServerResponseProcessor;
use FOS\RestBundle\View\View;

/**
 * Class RestServerDataObjectManager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDataObjectManager
{
    /**
     * @var RestRequestProcessor
     */
    protected $requestProcessor;

    /**
     * @var ServerResponseProcessor
     */
    protected $responseProcessor;

    /**
     * RestServerDataObjectManager constructor.
     *
     * @param RestRequestProcessor    $requestProcessor
     * @param ServerResponseProcessor $responseProcessor
     */
    public function __construct(RestRequestProcessor $requestProcessor, ServerResponseProcessor $responseProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->responseProcessor = $responseProcessor;
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return View
     */
    public function process(RestDataObject $dataObject): View
    {
        $dataObject = $this->requestProcessor->process($dataObject);

        return $this->responseProcessor->process($dataObject);
    }

    /**
     * @return RestRequestProcessor
     */
    public function getRequestProcessor(): RestRequestProcessor
    {
        return $this->requestProcessor;
    }

    /**
     * @param RestRequestProcessor $requestProcessor
     */
    public function setRequestProcessor(RestRequestProcessor $requestProcessor)
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