<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Component\Executor\MergeExecutor;
use CSC\Model\EntityInitializer;
use CSC\Protocol\Rest\Executor\PatchExecutor;
use CSC\Protocol\Rest\Server\Checker\UpdatableChecker;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class RestPutRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPutRequestProcessor extends AbstractRestRequestProcessor
{
    /**
     * @var UpdatableChecker
     */
    protected $checker;

    /**
     * @var PatchExecutor
     */
    protected $patchExecutor;

    /**
     * @var MergeExecutor
     */
    protected $mergeSimpleExecutor;

    /**
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestPutRequestProcessor constructor.
     *
     * @param UpdatableChecker         $checker
     * @param PatchExecutor            $patchExecutor
     * @param MergeExecutor            $mergeSimpleExecutor
     * @param RestResponseModelFactory $responseModelFactory
     */
    public function __construct(
        UpdatableChecker $checker,
        PatchExecutor $patchExecutor,
        MergeExecutor $mergeSimpleExecutor,
        RestResponseModelFactory $responseModelFactory
    )
    {
        $this->checker = $checker;
        $this->patchExecutor = $patchExecutor;
        $this->mergeSimpleExecutor = $mergeSimpleExecutor;
        $this->responseModelFactory = $responseModelFactory;
    }


    /**
     * @param RestDataObject|RestSimpleDataObject $dataObject
     *
     * @return RestDataObject
     */
    public function process(RestDataObject $dataObject): RestDataObject
    {
        $this->checker->check($dataObject);

        $object = $this->deserialize($dataObject->getFields(), $dataObject->getEntityName());

        if ($object instanceof EntityInitializer) {
            $object->initialize();
        }

        $this->processObject($object, $dataObject);

        return $dataObject;
    }

    /**
     * @param object               $object
     * @param RestSimpleDataObject $dataObject
     *
     * @throws ServerRequestException
     */
    public function processObject($object, RestSimpleDataObject $dataObject): void
    {
        $this->validateExternalObject($object, $dataObject);

        $object = $this->mergeSimpleExecutor->execute($object);

        $this->patchExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));
    }
}