<?php

namespace CSC\Protocol\Rest\Resolver;

use CSC\Protocol\Rest\Server\DataObject\RestPagerDataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class RestDataObjectPagerResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestDataObjectPagerResolver
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var int
     */
    private $limitPerPage;

    /**
     * RestPagerOrderedDataObjectResolver constructor.
     *
     * @param RequestStack $requestStack
     * @param int          $limitPerPage
     */
    public function __construct(RequestStack $requestStack, int $limitPerPage)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->limitPerPage = $limitPerPage;
    }

    /**
     * @param RestPagerDataObject $dataObject
     *
     * @return RestPagerDataObject
     */
    public function resolve(RestPagerDataObject $dataObject): RestPagerDataObject
    {
        $dataObject
            ->setPage($this->request->get('page', 1))
            ->setLimit($this->request->get('limit', $this->limitPerPage))
            ->setSort($this->request->get('sort', ''))
            ->setFilter($this->request->get('filter', ''))
            ->setRoutingParameters($this->request->attributes->get('_route_params', []))
        ;

        return $dataObject;
    }
}