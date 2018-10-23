<?php

namespace CSC\Controller;

use CSC\Server\DataObject\PagerDataObject;
use CSC\Server\DataObject\SimpleDataObject;
use CSC\Component\Rest\Manager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Class ApiController
 */
class ApiController extends FOSRestController
{
    /**
     * @param PagerDataObject $dataObject
     *
     * @return PagerDataObject
     */
    protected function callPagerOrderedResolver(PagerDataObject $dataObject): PagerDataObject
    {
        return $this->get('csc.data_object.pager_resolver')->resolve($dataObject);
    }

    /**
     * @param PagerDataObject $dataObject
     *
     * @return View
     */
    protected function callPagerOrderedProcessorManager(PagerDataObject $dataObject): View
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
     * @param PagerDataObject $dataObject
     *
     * @return View
     */
    protected function callPlainPagerOrderedProcessorManager(PagerDataObject $dataObject): View
    {
        return $this->get('csc.data_object_manager.plain_pager')->process($dataObject);
    }

    /**
     * @param SimpleDataObject $dataObject
     *
     * @return SimpleDataObject
     */
    protected function callSimpleDataObjectResolver(SimpleDataObject $dataObject): SimpleDataObject
    {
        return $this->get('csc.data_object.simple_resolver')->resolve($dataObject);
    }

    /**
     * @param SimpleDataObject $dataObject
     *
     * @return View
     */
    protected function callSimpleDataObjectProcessorManager(SimpleDataObject $dataObject): View
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
     * @param SimpleDataObject $dataObject
     * @param string[]             $validationGroups
     * @param string[]             $serializationGroups
     *
     * @return View
     */
    protected function processSimpleDataObject(
        SimpleDataObject $dataObject,
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
     * @param PagerDataObject $dataObject
     * @param string              $methodName
     * @param string[]            $validationGroups
     * @param string[]            $serializationGroups
     *
     * @return View
     */
    protected function processPagerOrderedDataObject(
        PagerDataObject $dataObject,
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
