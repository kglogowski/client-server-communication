<?php

namespace CSC\Protocol\Rest\Resolver;

use CSC\Protocol\Rest\Server\DataObject\RestSimpleDataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RestDataObjectSimpleResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDataObjectSimpleResolver
{
    /**
     * @var Request
     */
    private $request;

    /**
     * RestSimpleDataObjectResolver constructor.
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param RestSimpleDataObject $dataObject
     *
     * @return RestSimpleDataObject
     */
    public function resolve(RestSimpleDataObject $dataObject): RestSimpleDataObject
    {
        $dataObject
            ->setFields($this->request->getContent())
            ->setRoutingParameters($this->request->attributes->get('_route_params', []))
        ;

        return $dataObject;
    }
}