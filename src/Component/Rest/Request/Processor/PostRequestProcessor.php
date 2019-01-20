<?php

namespace CSC\Component\Rest\Request\Processor;

use CSC\Component\Doctrine\Executor\InsertExecutor;
use CSC\Component\Doctrine\Executor\MergeExecutor;
use CSC\Model\Interfaces\EntityInitializer;
use CSC\Component\Rest\Request\Checker\InsertableChecker;
use CSC\Component\Rest\DataObject\DataObject;
use CSC\Component\Rest\DataObject\SimpleDataObjectInterface;
use CSC\Component\Rest\Response\Factory\ResponseModelFactory;
use CSC\Component\Rest\Response\Model\ServerResponseModel;

/**
 * Class PostRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PostRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var InsertableChecker
     */
    protected $checker;

    /**
     * @var InsertExecutor
     */
    protected $insertExecutor;

    /**
     * @var MergeExecutor
     */
    protected $mergeExecutor;

    /**
     * @var ResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * PostRequestProcessor constructor.
     *
     * @param InsertableChecker    $checker
     * @param InsertExecutor       $insertExecutor
     * @param MergeExecutor        $mergeExecutor
     * @param ResponseModelFactory $responseModelFactory
     */
    public function __construct(
        InsertableChecker $checker,
        InsertExecutor $insertExecutor,
        MergeExecutor $mergeExecutor,
        ResponseModelFactory $responseModelFactory
    )
    {
        $this->checker = $checker;
        $this->insertExecutor = $insertExecutor;
        $this->mergeExecutor = $mergeExecutor;
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param DataObject|SimpleDataObjectInterface $dataObject
     *
     * @return DataObject
     * @throws \Exception
     */
    public function process(DataObject $dataObject): DataObject
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
     * @param ServerResponseModel       $object
     * @param SimpleDataObjectInterface $dataObject
     *
     * @throws \Exception
     */
    public function processObject(ServerResponseModel $object, SimpleDataObjectInterface $dataObject)
    {
        $this->validateExternalObject($object, $dataObject);

        $this->checkVoters($dataObject->getVoters(), $object);

        $object = $this->mergeExecutor->execute($object, true);
        $this->insertExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));
    }
}