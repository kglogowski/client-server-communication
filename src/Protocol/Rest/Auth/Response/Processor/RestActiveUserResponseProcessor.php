<?php

namespace CSC\Protocol\Rest\Auth\Response\Processor;

use CSC\Component\Provider\UserProvider;
use CSC\Protocol\Rest\Server\DataObject\RestDataObject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestActiveUserResponseProcessor
 */
class RestActiveUserResponseProcessor
{
    const SERIALIZATION_GROUP_AUTH = 'Auth';

    /**
     * @var UserProvider
     */
    protected $userProvider;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * RestActiveUserResponseProcessor constructor.
     *
     * @param UserProvider $userProvider
     * @param Serializer   $serializer
     */
    public function __construct(UserProvider $userProvider, Serializer $serializer)
    {
        $this->userProvider = $userProvider;
        $this->serializer = $serializer;
    }

    /**
     * @return Response
     */
    public function process(): Response
    {
        $response = new JsonResponse();

        $response
            ->setStatusCode(Response::HTTP_OK)
            ->setContent($this->serializer->serialize($this->userProvider->getUser(), 'json', $this->createContext()))
        ;

        return $response;
    }

    /**
     * @return SerializationContext
     */
    protected function createContext()
    {
        $context = new SerializationContext();

        $context->setGroups([self::SERIALIZATION_GROUP_AUTH, RestDataObject::ANY]);

        return $context;
    }
}