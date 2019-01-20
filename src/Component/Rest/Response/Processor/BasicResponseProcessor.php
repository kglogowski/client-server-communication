<?php

namespace CSC\Component\Rest\Response\Processor;

use CSC\Component\Provider\HttpSuccessStatusProvider;
use CSC\Component\Rest\DataObject\DataObject;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Context\Context;

/**
 * Class BasicResponseProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class BasicResponseProcessor implements ResponseProcessor
{
    /**
     * @var HttpSuccessStatusProvider
     */
    protected $httpSuccessStatusProvider;

    /**
     * BasicResponseProcessor constructor.
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
        /** @var DataObject $dataObject */
        $view = new View($dataObject->getResponseModel(), $this->httpSuccessStatusProvider->getSuccessStatus($dataObject->getHttpMethod(), $dataObject->isAsync()));

        $view->setContext($this->createContext($dataObject));

        return $view;
    }
    /**
     * @param DataObject $dataObject
     *
     * @return Context
     */
    protected function createContext(DataObject $dataObject)
    {
        $context = new Context();

        $context->setGroups($dataObject->getSerializationGroups());

        return $context;
    }
}