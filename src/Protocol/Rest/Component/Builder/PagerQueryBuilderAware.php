<?php

namespace CSC\Protocol\Rest\Component\Builder;

/**
 * Interface PagerQueryBuilderAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerQueryBuilderAware
{
    /**
     * @param RestPagerQueryBuilder $builder
     */
    public function setPagerQueryBuilder(RestPagerQueryBuilder $builder);
}