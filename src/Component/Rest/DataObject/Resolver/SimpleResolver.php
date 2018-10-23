<?php

namespace CSC\Component\Resolver;

use CSC\Server\DataObject\SimpleDataObject;
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
     * @param SimpleDataObject $dataObject
     *
     * @return SimpleDataObject
     */
    public function resolve(SimpleDataObject $dataObject): SimpleDataObject
    {
        $dataObject
            ->setFields($this->request->getContent())
            ->setRoutingParameters($this->request->attributes->get('_route_params', []))
        ;

        return $dataObject;
    }
}