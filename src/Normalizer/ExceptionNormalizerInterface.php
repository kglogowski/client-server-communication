<?php

namespace CSC\Normalizer;

/**
 * Interface ExceptionNormalizerInterface
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface ExceptionNormalizerInterface
{
    const ERROR_TYPE = 'system_error';

    const
        KEY_ERROR       = 'error',
        KEY_DESCRIPTION = 'description',
        KEY_DETAILS     = 'details',
        KEY_CODE        = 'code'
    ;

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function normalize(\Exception $exception): array;
}
