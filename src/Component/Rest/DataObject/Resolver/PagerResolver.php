<?php

namespace CSC\Component\Resolver;

use CSC\Server\DataObject\PagerDataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PagerResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerResolver
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
     * PagerResolver constructor.
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
     * @param PagerDataObject $dataObject
     *
     * @return PagerDataObject
     */
    public function resolve(PagerDataObject $dataObject): PagerDataObject
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