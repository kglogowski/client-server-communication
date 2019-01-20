<?php

namespace CSC\Component\Auth\Response\Processor;

use CSC\Component\Auth\Security\Provider\UserProvider;
use CSC\Server\DataObject\DataObject;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ActiveUserResponseProcessor
 */
class ActiveUserResponseProcessor
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
     * ActiveUserResponseProcessor constructor.
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

        $context->setGroups([self::SERIALIZATION_GROUP_AUTH, DataObject::ANY]);

        return $context;
    }
}