<?php

namespace CSC\Protocol\Rest\Server\Response\Factory;

use CSC\Protocol\Rest\Server\Response\Model\RestPagerResponseModel;
use CSC\Server\Response\Model\ServerResponseModel;

class RestPagerResponseModelFactory implements RestResponseModelFactory
{
    /**
     * @var RestResponseModelFactory
     */
    protected $responseModelFactory;

    /**
     * RestPagerResponseModelFactory constructor.
     *
     * @param RestResponseModelFactory $responseModelFactory
     */
    public function __construct(RestResponseModelFactory $responseModelFactory)
    {
        $this->responseModelFactory = $responseModelFactory;
    }

    /**
     * @param RestPagerResponseModel $object
     *
     * @return ServerResponseModel
     */
    public function create($object): ServerResponseModel
    {
        foreach ($object->getItems() as $item) {
            $this->responseModelFactory->create($item);
        }

        return $object;
    }
}