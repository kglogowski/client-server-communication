<?php

namespace CSC\Component\Rest;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\Request\Processor\RequestProcessor;
use CSC\Component\Rest\Response\Processor\ResponseProcessor;
use FOS\RestBundle\View\View;

/**
 * Class Manager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class Manager
{
    /**
     * @var RequestProcessor
     */
    protected $requestProcessor;

    /**
     * @var ResponseProcessor
     */
    protected $responseProcessor;

    /**
     * Manager constructor.
     *
     * @param RequestProcessor  $requestProcessor
     * @param ResponseProcessor $responseProcessor
     */
    public function __construct(RequestProcessor $requestProcessor, ResponseProcessor $responseProcessor)
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
     * @return ResponseProcessor
     */
    public function getResponseProcessor(): ResponseProcessor
    {
        return $this->responseProcessor;
    }

    /**
     * @param ResponseProcessor $responseProcessor
     */
    public function setResponseProcessor(ResponseProcessor $responseProcessor)
    {
        $this->responseProcessor = $responseProcessor;
    }
}