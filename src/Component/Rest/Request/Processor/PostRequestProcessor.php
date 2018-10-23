<?php

namespace CSC\Server\Request\Processor;

use CSC\Component\Executor\InsertExecutor;
use CSC\Component\Executor\MergeExecutor;
use CSC\Model\Interfaces\EntityInitializer;
use CSC\Server\Checker\FieldsCheckerSimpleDataObjectInterface;
use CSC\Server\DataObject\DataObject;
use CSC\Server\DataObject\SimpleDataObject;
use CSC\Server\Response\Factory\ResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;
use CSC\Server\Response\Model\ServerResponseModel;

/**
 * Class PostRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PostRequestProcessor extends AbstractRequestProcessor
{
    /**
     * @var FieldsCheckerSimpleDataObjectInterface
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
     * @param FieldsCheckerSimpleDataObjectInterface $checker
     * @param InsertExecutor                         $insertExecutor
     * @param MergeExecutor                          $mergeExecutor
     * @param ResponseModelFactory               $responseModelFactory
     */
    public function __construct(
        FieldsCheckerSimpleDataObjectInterface $checker,
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
     * @param DataObject|SimpleDataObject $dataObject
     *
     * @return DataObject
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
     * @param ServerResponseModel  $object
     * @param SimpleDataObject $dataObject
     *
     * @throws ServerRequestException
     */
    public function processObject(ServerResponseModel $object, SimpleDataObject $dataObject)
    {
        $this->validateExternalObject($object, $dataObject);

        $this->checkVoters($dataObject->getVoters(), $object);

        $object = $this->mergeExecutor->execute($object, true);
        $this->insertExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));
    }
}