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

    /**
     * @param \Exception $exception
     *
     * @return array
     */
    public function normalize(\Exception $exception): array;
}
