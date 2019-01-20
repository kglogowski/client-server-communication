<?php

namespace CSC\Controller;

use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\PagerDataObjectInterface;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;
use CSC\Component\Rest\Manager;
use CSC\Component\Rest\Request\Processor\RequestProcessor;
use CSC\Component\Rest\Response\Processor\ResponseProcessor;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Class ApiController
 */
class ApiController extends FOSRestController
{
    /**
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PagerDataObjectInterface
     */
    protected function callPagerOrderedResolver(PagerDataObjectInterface $dataObject): PagerDataObjectInterface
    {
        return $this->get('csc.data_object.pager_resolver')->resolve($dataObject);
    }

    /**
     * @param PagerDataObjectInterface $dataObject
     *
     * @return View
     */
    protected function callPagerOrderedProcessorManager(PagerDataObjectInterface $dataObject): View
    {
        return $this->getPagerDataObjectProcessorManager()->process($dataObject);
    }

    /**
     * @return Manager
     */
    protected function getPagerDataObjectProcessorManager(): Manager
    {
        return $this->get('csc.data_object_manager.pager');
    }

    /**
     * @param PagerDataObjectInterface $dataObject
     *
     * @return View
     */
    protected function callPlainPagerOrderedProcessorManager(PagerDataObjectInterface $dataObject): View
    {
        return $this->get('csc.data_object_manager.plain_pager')->process($dataObject);
    }

    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return SimpleDataObjectInterface
     */
    protected function callSimpleDataObjectResolver(SimpleDataObjectInterface $dataObject): SimpleDataObjectInterface
    {
        return $this->get('csc.data_object.simple_resolver')->resolve($dataObject);
    }

    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return View
     */
    protected function callSimpleDataObjectProcessorManager(SimpleDataObjectInterface $dataObject): View
    {
        return $this->getSimpleDataObjectProcessorManager()->process($dataObject);
    }

    /**
     * @return Manager
     */
    protected function getSimpleDataObjectProcessorManager(): Manager
    {
        return $this->get('csc.data_object_manager.crud');
    }

    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return View
     */
    protected function processSimpleDataObject(SimpleDataObjectInterface $dataObject): View
    {
        $this->callSimpleDataObjectResolver($dataObject);

        if (array_key_exists(DataObject::VALUE_REQUEST_PROCESSOR, $dataObject->getRoutingParameters())) {
            /** @var RequestProcessor $requestProcessor */
            $requestProcessor = $this->container->get($dataObject->getRoutingValue(DataObject::VALUE_REQUEST_PROCESSOR));

            $this->getSimpleDataObjectProcessorManager()
                ->setRequestProcessor($requestProcessor)
            ;
        }

        if (array_key_exists(DataObject::VALUE_RESPONSE_PROCESSOR, $dataObject->getRoutingParameters())) {
            /** @var ResponseProcessor $responseProcessor */
            $responseProcessor = $this->container->get($dataObject->getRoutingValue(DataObject::VALUE_RESPONSE_PROCESSOR));

            $this->getSimpleDataObjectProcessorManager()
                ->setResponseProcessor($responseProcessor)
            ;
        }

        $responseView = $this->callSimpleDataObjectProcessorManager($dataObject);

        return $responseView;
    }

    /**
     * @param PagerDataObjectInterface $dataObject
     *
     * @return View
     */
    protected function processPagerOrderedDataObject(PagerDataObjectInterface $dataObject): View
    {
        $this->callPagerOrderedResolver($dataObject);

        if (array_key_exists(DataObject::VALUE_REQUEST_PROCESSOR, $dataObject->getRoutingParameters())) {
            /** @var RequestProcessor $requestProcessor */
            $requestProcessor = $this->container->get($dataObject->getRoutingValue(DataObject::VALUE_REQUEST_PROCESSOR));

            $this->getPagerDataObjectProcessorManager()
                ->setRequestProcessor($requestProcessor)
            ;
        }

        if (array_key_exists(DataObject::VALUE_RESPONSE_PROCESSOR, $dataObject->getRoutingParameters())) {
            /** @var ResponseProcessor $responseProcessor */
            $responseProcessor = $this->container->get($dataObject->getRoutingValue(DataObject::VALUE_RESPONSE_PROCESSOR));

            $this->getPagerDataObjectProcessorManager()
                ->setResponseProcessor($responseProcessor)
            ;
        }

        $responseView = $this->callPagerOrderedProcessorManager($dataObject);

        return $responseView;
    }
}
