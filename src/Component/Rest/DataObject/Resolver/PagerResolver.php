<?php

namespace CSC\Component\Rest\Request\Resolver;

use CSC\Server\DataObject\PagerDataObjectInterface;
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
     * @param PagerDataObjectInterface $dataObject
     *
     * @return PagerDataObjectInterface
     */
    public function resolve(PagerDataObjectInterface $dataObject): PagerDataObjectInterface
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