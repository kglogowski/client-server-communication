<?php

namespace CSC\Server\Manager;

use CSC\Server\DataObject\DataObjectInterface;
use CSC\Server\Request\Processor\ServerRequestProcessorInterface;
use CSC\Server\Response\Processor\ServerResponseProcessorInterface;

/**
 * Class ServerDataObjectProcessorManager
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ServerDataObjectProcessorManager
{
    /**
     * @var ServerRequestProcessorInterface
     */
    protected $requestProcessor;

    /**
     * @var ServerResponseProcessorInterface
     */
    protected $responseProcessor;
    /**
     * ServerDataObjectProcessorManager constructor.
     *
     * @param ServerRequestProcessorInterface  $requestProcessor
     * @param ServerResponseProcessorInterface $responseProcessor
     */
    public function __construct(ServerRequestProcessorInterface $requestProcessor, ServerResponseProcessorInterface $responseProcessor)
    {
        $this->requestProcessor = $requestProcessor;
        $this->responseProcessor = $responseProcessor;
    }

    /**
     * @param DataObjectInterface $dataObject
     *
     * @return mixed
     */
    public function process(DataObjectInterface $dataObject)
    {
        $responseModel = $this->requestProcessor->process($dataObject);

        return $this->responseProcessor->process($responseModel, $dataObject);
    }
}