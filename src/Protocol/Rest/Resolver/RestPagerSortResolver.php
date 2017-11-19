<?php

namespace CSC\Protocol\Rest\Resolver;

use CSC\Protocol\Rest\Modernizer\QueryBuilderFilterModernizer;
use CSC\Model\SortModel;

/**
 * Class RestPagerSortResolver
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerSortResolver
{
    const PREG_MATCH_COUNT_FOR_FILLED_SORTING_DIRECTION = 3;

    /**
     * @param string $sort
     *
     * @return array
     */
    public function resolveParams(string $sort): array
    {
        $sortedElements = [];

        foreach (explode(',', $sort) as $sortElement) {
            if ('' === $sortElement) {
                continue;
            }

            preg_match('/^(.+){(.+)}|(.+)$/', $sortElement, $sortParameters);

            if (self::PREG_MATCH_COUNT_FOR_FILLED_SORTING_DIRECTION === count($sortParameters)) {
                $field = $sortParameters[1];
                $direction = strtolower($sortParameters[2]);
            } else {
                $field = $sortParameters[0];
                $direction = QueryBuilderFilterModernizer::DIRECTION_ASCENDING;
            }

            if ('' === $field) {
                throw new \LogicException('Incorrect parameters to sorting');
            }

            $pagerOrderedSortModel = (new SortModel())
                ->setField($field)
                ->setDirection($direction)
            ;

            $sortedElements[] = $pagerOrderedSortModel;
        }

        return $sortedElements;
    }
}