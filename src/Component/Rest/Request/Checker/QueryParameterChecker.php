<?php

namespace CSC\Component\Rest\Request\Checker;

use CSC\Translate\TranslateDictionary;
use CSC\Model\SortModel;
use CSC\Model\QueryFilterModel;
use CSC\Exception\ServerRequestException;

/**
 * Class QueryParameterChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class QueryParameterChecker
{
    /**
     * @param QueryFilterModel $filterModel
     * @param array            $filterSupportedParameters
     *
     * @throws ServerRequestException
     */
    public function checkFilterParameter(QueryFilterModel $filterModel, array $filterSupportedParameters)
    {
        if (!in_array($filterModel->getField(), $filterSupportedParameters, true)) {
            throw new ServerRequestException(
                ServerRequestException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_NOT_SUPPORTED_FILTER,
                [$filterModel->getField()]
            );
        }
    }

    /**
     * @param SortModel $sortModel
     * @param array     $sortSupportedParameters
     *
     * @throws ServerRequestException
     */
    public function checkSortParameter(SortModel $sortModel, array $sortSupportedParameters)
    {
        if (!in_array($sortModel->getField(), $sortSupportedParameters, true)) {
            throw new ServerRequestException(
                ServerRequestException::ERROR_TYPE_INVALID_PARAMETER,
                TranslateDictionary::KEY_NOT_SUPPORTED_SORT_PARAMETER,
                [$sortModel->getField()]
            );
        }
    }
}