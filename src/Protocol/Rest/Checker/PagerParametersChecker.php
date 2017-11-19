<?php

namespace CSC\Protocol\Rest\Checker;

use CSC\Protocol\Rest\Server\Request\Model\PagerSortModel;
use CSC\Protocol\Rest\Server\Request\Model\QueryFilterModel;
use CSC\Server\Request\Exception\ServerRequestException;

/**
 * Class PagerParametersChecker
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class PagerParametersChecker
{
    const MESSAGE_NOT_SUPPORTED_FILTER = 'Not supported filter';
    const MESSAGE_NOT_SUPPORTED_SORT_PARAMETER = 'Not supported sort parameter';

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
                self::MESSAGE_NOT_SUPPORTED_FILTER,
                [$filterModel->getField()]
            );
        }
    }

    /**
     * @param PagerSortModel $sortModel
     * @param array          $sortSupportedParameters
     *
     * @throws ServerRequestException
     */
    public function checkSortParameter(PagerSortModel $sortModel, array $sortSupportedParameters)
    {
        if (!in_array($sortModel->getField(), $sortSupportedParameters, true)) {
            throw new ServerRequestException(
                ServerRequestException::ERROR_TYPE_INVALID_PARAMETER,
                self::MESSAGE_NOT_SUPPORTED_SORT_PARAMETER,
                [$sortModel->getField()]
            );
        }
    }
}