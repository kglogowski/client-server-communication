<?php

namespace CSC\Component\Rest\Request\Resolver;

use CSC\Server\DataObject\SimpleDataObjectInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SimpleResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class SimpleResolver
{
    /**
     * @var Request
     */
    private $request;

    /**
     * SimpleResolver constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param SimpleDataObjectInterface $dataObject
     *
     * @return SimpleDataObjectInterface
     */
    public function resolve(SimpleDataObjectInterface $dataObject): SimpleDataObjectInterface
    {
        $dataObject
            ->setFields($this->request->getContent())
            ->setRoutingParameters($this->request->attributes->get('_route_params', []))
        ;

        return $dataObject;
    }
}