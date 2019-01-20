<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Exception\ServerRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class SimpleRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class CrudRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var RequestProcessor|null
     */
    protected $postProcessor;

    /**
     * @var RequestProcessor|null
     */
    protected $getProcessor;

    /**
     * @var RequestProcessor|null
     */
    protected $putProcessor;

    /**
     * @var RequestProcessor|null
     */
    protected $deleteProcessor;

    /**
     * CrudRequestProcessor constructor.
     *
     * @param RequestProcessor|null $postProcessor
     * @param RequestProcessor|null $getProcessor
     * @param RequestProcessor|null $putProcessor
     * @param RequestProcessor|null $deleteProcessor
     */
    public function __construct(
        ?RequestProcessor $postProcessor,
        ?RequestProcessor $getProcessor,
        ?RequestProcessor $putProcessor,
        ?RequestProcessor $deleteProcessor
    )
    {
        $this->postProcessor = $postProcessor;
        $this->getProcessor = $getProcessor;
        $this->putProcessor = $putProcessor;
        $this->deleteProcessor = $deleteProcessor;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return DataObject
     */
    public function process(DataObject $dataObject): DataObject
    {
        $this->setupDataObject($dataObject);

        $httpMethod = strtolower($dataObject->getHttpMethod());

        $activeProcessorName = sprintf('%sProcessor', $httpMethod);

        /** @var RequestProcessor $activeProcessor */
        $activeProcessor = $this->$activeProcessorName;

        if ($activeProcessor instanceof RequestProcessor) {
            return $activeProcessor->process($dataObject);
        }

        throw new HttpException(
            Response::HTTP_METHOD_NOT_ALLOWED,
            sprintf('Http method "%s" is not available', strtoupper($httpMethod))
        );
    }
}