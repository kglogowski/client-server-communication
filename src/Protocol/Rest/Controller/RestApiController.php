<?php

namespace CSC\Controller;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Manager\RestDataObjectManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Class RestApiController
 */
class RestApiController extends FOSRestController
{
    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return RestPagerDataObject
     */
    protected function callPagerOrderedResolver(RestPagerDataObject $dataObject): RestPagerDataObject
    {
        return $this->get('csc.rest.data_object.pager_resolver')->resolve($dataObject);
    }

    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return View
     */
    protected function callPagerOrderedProcessorManager(RestPagerDataObject $dataObject): View
    {
        return $this->getPagerDataObjectProcessorManager()->process($dataObject);
    }

    /**
     * @return RestDataObjectManager
     */
    protected function getPagerDataObjectProcessorManager(): RestDataObjectManager
    {
        return $this->get('csc.rest.data_object_manager.pager');
    }

    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return View
     */
    protected function callPlainPagerOrderedProcessorManager(RestPagerDataObject $dataObject): View
    {
        return $this->get('csc.rest.data_object_manager.plain_pager')->process($dataObject);
    }

    /**
     * @param RestSimpleDataObject $dataObject
     *
     * @return RestSimpleDataObject
     */
    protected function callSimpleDataObjectResolver(RestSimpleDataObject $dataObject): RestSimpleDataObject
    {
        return $this->get('csc.rest.data_object.simple_resolver')->resolve($dataObject);
    }

    /**
     * @param RestSimpleDataObject $dataObject
     *
     * @return View
     */
    protected function callSimpleDataObjectProcessorManager(RestSimpleDataObject $dataObject): View
    {
        return $this->getSimpleDataObjectProcessorManager()->process($dataObject);
    }

    /**
     * @return RestDataObjectManager
     */
    protected function getSimpleDataObjectProcessorManager(): RestDataObjectManager
    {
        return $this->get('csc.rest.data_object_manager.crud');
    }

    /**
     * @param RestSimpleDataObject $dataObject
     * @param string[]             $validationGroups
     * @param string[]             $serializationGroups
     *
     * @return View
     */
    protected function processSimpleDataObject(
        RestSimpleDataObject $dataObject,
        array $validationGroups = [],
        array $serializationGroups = []
    ): View
    {
        $dataObject
            ->setSerializationGroups($serializationGroups)
            ->setValidationGroups($validationGroups)
        ;

        $this->callSimpleDataObjectResolver($dataObject);

        $responseView = $this->callSimpleDataObjectProcessorManager($dataObject);

        return $responseView;
    }

    /**
     * @param RestPagerDataObject $dataObject
     * @param string              $methodName
     * @param string[]            $validationGroups
     * @param string[]            $serializationGroups
     *
     * @return View
     */
    protected function processPagerOrderedDataObject(
        RestPagerDataObject $dataObject,
        string $methodName,
        array $validationGroups = [],
        array $serializationGroups = []
    ): View
    {
        $dataObject
            ->setMethodName($methodName)
            ->setSerializationGroups($serializationGroups)
            ->setValidationGroups($validationGroups)
        ;

        $this->callPagerOrderedResolver($dataObject);

        $responseView = $this->callPagerOrderedProcessorManager($dataObject);

        return $responseView;
    }
}
