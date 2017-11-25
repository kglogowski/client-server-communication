<?php

namespace CSC\Tests\Protocol\Rest\Builder;

use CSC\Component\Builder\QueryFilterBuilder;
use CSC\Component\Checker\QueryParameterChecker;
use CSC\Protocol\Rest\Builder\RestPagerQueryBuilder;

/**
 * Class RestPagerQueryBuilderTestFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryBuilderTestFactory
{
    /**
     * @return RestPagerQueryBuilder
     */
    public static function create(): RestPagerQueryBuilder
    {
        return new RestPagerQueryBuilder(
            new QueryFilterBuilder(),
            new QueryParameterChecker()
        );
    }
}