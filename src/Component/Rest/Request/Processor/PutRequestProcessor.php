<?php

namespace CSC\Server\Request\Processor;

use CSC\Component\Executor\MergeExecutor;
use CSC\Model\Interfaces\EntityInitializer;
use CSC\Component\Executor\PatchExecutor;
use CSC\Server\Checker\UpdatableChecker;
use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\SimpleDataObjectInterface;
use CSC\Server\Response\Factory\ResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Server\Response\Model\ServerResponseModel;

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