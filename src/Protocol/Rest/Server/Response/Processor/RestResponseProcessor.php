<?php

namespace CSC\Protocol\Rest\Server\Response\Processor;

use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\Provider\HttpSuccessStatusProvider;
use CSC\Server\DataObject\DataObject;
use FOS\RestBundle\View\View;

/**
 * Class RestResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestResponseProcessor extends AbstractRestResponseProcessor
{
    /**
     * @var HttpSuccessStatusProvider
     */
    protected $httpSuccessStatusProvider;

    /**
     * RestResponseProcessor constructor.
     *
     * @param HttpSuccessStatusProvider $httpSuccessStatusProvider
     */
    public function __construct(HttpSuccessStatusProvider $httpSuccessStatusProvider)
    {
        $this->httpSuccessStatusProvider = $httpSuccessStatusProvider;
    }

    /**
     * @param DataObject $dataObject
     *
     * @return View
     */
    public function process(DataObject $dataObject): View
    {
        /** @var RestDataObject $dataObject */
        $view = new View($dataObject->getResponseModel(), $this->httpSuccessStatusProvider->getSuccessStatus($dataObject->getHttpMethod(), $dataObject->isAsync()));

        $view->setContext($this->createContext($dataObject));

        return $view;
    }
}