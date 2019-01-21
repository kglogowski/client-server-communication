<?php

namespace CSC\Model\Traits;

use CSC\Component\Rest\Request\Builder\PagerQueryBuilder;
use CSC\Component\Rest\Request\Builder\QueryFilterBuilder;
use CSC\Model\PagerRequestModel;
use CSC\Model\QueryFilterModel;

/**
 * Trait SoftDeleteRepositoryTrait
 */
trait SoftDeleteRepositoryTrait
{
    /**
     * @param PagerQueryBuilder $builder
     * @param string                $alias
     * @param PagerRequestModel     $requestModel
     *
     * @throws \Exception
     */
    public function addSoftDeleteFilter(
        PagerQueryBuilder $builder,
        string $alias,
        PagerRequestModel $requestModel
    ): void
    {
        foreach ($requestModel->getFilter() as $filterModel) {
            if ('is_deleted' === $filterModel->getField()) {
                return;
            }
        }

        $filterModel = (new QueryFilterModel())
            ->setField('is_deleted')
            ->setOperator(QueryFilterBuilder::BOOLEAN)
            ->setValue(false)
        ;

        $builder->addFilter($filterModel, $alias);
    }
}