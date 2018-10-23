<?php

namespace CSC\Component\Builder;

/**
 * Interface PagerQueryBuilderAware
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface PagerQueryBuilderAware
{
    /**
     * @param PagerQueryBuilder $builder
     */
    public function setPagerQueryBuilder(PagerQueryBuilder $builder);
}