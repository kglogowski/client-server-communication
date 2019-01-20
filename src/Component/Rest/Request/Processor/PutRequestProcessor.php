<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Doctrine\Executor\MergeExecutor;
use CSC\Model\Interfaces\EntityInitializer;
use CSC\Component\Doctrine\Executor\PatchExecutor;
use CSC\Component\Rest\Request\Checker\UpdatableChecker;
use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Exception\ServerRequestException;
use CSC\Component\Rest\Response\Model\ServerResponseModel;

/**
 * Class PutRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PutRequestProcessor extends AbstractRequestProcessor
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
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * PutRequestProcessor constructor.
     *
     * @param UpdatableChecker         $checker
     * @param PatchExecutor            $patchExecutor
     * @param MergeExecutor            $mergeSimpleExecutor
     * @param ResponseModelFactory $responseModelFactory
     */
    public function __construct(
        UpdatableChecker $checker,
        PatchExecutor $patchExecutor,
        MergeExecutor $mergeSimpleExecutor,
        ResponseModelFactory $responseModelFactory
    )
    {
        $this->checker = $checker;
        $this->patchExecutor = $patchExecutor;
        $this->mergeSimpleExecutor = $mergeSimpleExecutor;
        $this->responseModelFactory = $responseModelFactory;
    }


    /**
     * @param DataObject|SimpleDataObjectInterface $dataObject
     *
     * @return DataObject
     *
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
    {
        $this->checker->check($dataObject);

        $changesObject = $this->deserialize($dataObject->getFields(), $dataObject->getEntityName());

        /** @var ServerResponseModel $object */
        $object = $this->patchExecutor->resolve($changesObject, $dataObject);

        if ($object instanceof EntityInitializer) {
            $object->initialize();
        }

        $this->processObject($object, $dataObject);

        return $dataObject;
    }

    /**
     * @param ServerResponseModel       $object
     * @param SimpleDataObjectInterface $dataObject
     *
     * @throws \Exception
     */
    public function processObject(ServerResponseModel $object, SimpleDataObjectInterface $dataObject): void
    {
        $this->validateExternalObject($object, $dataObject);

        $this->checkVoters($dataObject->getVoters(), $object);

        $object = $this->mergeSimpleExecutor->execute($object);

        $this->patchExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));
    }
}