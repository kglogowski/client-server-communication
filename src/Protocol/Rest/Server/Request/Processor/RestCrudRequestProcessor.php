<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Server\Request\Exception\ServerRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RestSimpleRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestCrudRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var RestRequestProcessor|null
     */
    protected $postProcessor;

    /**
     * @var RestRequestProcessor|null
     */
    protected $getProcessor;

    /**
     * @var RestRequestProcessor|null
     */
    protected $putProcessor;

    /**
     * @var RestRequestProcessor|null
     */
    protected $deleteProcessor;

    /**
     * RestCrudRequestProcessor constructor.
     *
     * @param RestRequestProcessor|null $postProcessor
     * @param RestRequestProcessor|null $getProcessor
     * @param RestRequestProcessor|null $putProcessor
     * @param RestRequestProcessor|null $deleteProcessor
     */
    public function __construct(
        ?RestRequestProcessor $postProcessor,
        ?RestRequestProcessor $getProcessor,
        ?RestRequestProcessor $putProcessor,
        ?RestRequestProcessor $deleteProcessor
    )
    {
        $this->postProcessor = $postProcessor;
        $this->getProcessor = $getProcessor;
        $this->putProcessor = $putProcessor;
        $this->deleteProcessor = $deleteProcessor;
    }

    /**
     * @param RestDataObject $dataObject
     *
     * @return RestDataObject
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {
        $this->setupDataObject($dataObject);

        $httpMethod = strtolower($dataObject->getHttpMethod());

        $activeProcessorName = sprintf('%sProcessor', $httpMethod);

        /** @var RestRequestProcessor $activeProcessor */
        $activeProcessor = $this->$activeProcessorName;

        if ($activeProcessor instanceof RestRequestProcessor) {
            return $activeProcessor->process($dataObject);
        }

        throw new HttpException(
            Response::HTTP_METHOD_NOT_ALLOWED,
            sprintf('Http method %s is not available', $httpMethod)
        );
    }
}