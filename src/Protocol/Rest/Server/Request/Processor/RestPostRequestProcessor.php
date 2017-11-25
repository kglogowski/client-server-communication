<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Component\Executor\InsertExecutor;
use CSC\Component\Executor\MergeExecutor;
use CSC\Model\Interfaces\EntityInitializer;
use CSC\Protocol\Rest\Server\Checker\FieldsCheckerSimpleDataObjectInterface;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Response\Factory\RestResponseModelFactory;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class RestPostRequestProcessor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPostRequestProcessor extends AbstractRestRequestProcessor
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
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestPostRequestProcessor constructor.
     *
     * @param FieldsCheckerSimpleDataObjectInterface $checker
     * @param InsertExecutor                         $insertExecutor
     * @param MergeExecutor                          $mergeExecutor
     * @param RestResponseModelFactory               $responseModelFactory
     */
    public function __construct(
        FieldsCheckerSimpleDataObjectInterface $checker,
        InsertExecutor $insertExecutor,
        MergeExecutor $mergeExecutor,
        RestResponseModelFactory $responseModelFactory
    )
    {
        $this->checker = $checker;
        $this->insertExecutor = $insertExecutor;
        $this->mergeExecutor = $mergeExecutor;
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
    public function processObject($object, RestSimpleDataObject $dataObject)
    {
        $this->validateExternalObject($object, $dataObject);

        $object = $this->mergeExecutor->execute($object, true);
        $this->insertExecutor->execute($object);

        $dataObject->setResponseModel($this->responseModelFactory->create($object));
    }
}