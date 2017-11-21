<?php

namespace CSC\Protocol\Rest\Server\Request\Processor;

use CSC\Executor\AbstractDoctrineExecutor;
use CSC\Protocol\Rest\Server\Checker\FieldsCheckerSimpleDataObjectInterface;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use CSC\Protocol\Rest\Server\Response\Factory\RestSimpleResponseModelFactory;
use CSC\Server\Response\Model\ServerResponseModel;

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
     * @var AbstractDoctrineExecutor
     */
    protected $insertExecutor;

    /**
     * @var AbstractDoctrineExecutor
     */
    protected $mergeExecutor;

    /**
     * @var RestSimpleResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestPostRequestProcessor constructor.
     *
     * @param FieldsCheckerSimpleDataObjectInterface $checker
     * @param AbstractDoctrineExecutor               $insertExecutor
     * @param AbstractDoctrineExecutor               $mergeExecutor
     * @param RestSimpleResponseModelFactory         $responseModelFactory
     */
    public function __construct(
        FieldsCheckerSimpleDataObjectInterface $checker,
        AbstractDoctrineExecutor $insertExecutor,
        AbstractDoctrineExecutor $mergeExecutor,
        RestSimpleResponseModelFactory $responseModelFactory
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

        //TODO STOP
        if ($object instanceof EntityInitializerInterface) {
            $object->initialize();
        }

        return $this->processObject($object, $dataObject);
    }

    /**
     * @param object                              $object
     * @param ServerRestSimpleDataObjectInterface $dataObject
     *
     * @return ServerRestResponseModelInterface
     *
     * @throws ServerRequestException
     */
    public function processObject($object, ServerRestSimpleDataObjectInterface $dataObject): ServerRestResponseModelInterface
    {
        $this->validateExternalObject($object, $dataObject);

        $object = $this->mergeSimpleExecutor->execute($object, true);
        $this->insertSimpleExecutor->execute($object);

        return $this->restResponseModelFactory->create($object);
    }
}