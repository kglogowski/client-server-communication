<?php

namespace CSC\Normalizer;

/**
 * Class HttpExceptionNormalizer
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class HttpExceptionNormalizer implements ExceptionNormalizerInterface
{
    const ERROR_TYPE = 'system_error';

    /**
     * {@inheritdoc}
     */
    public function normalize(\Exception $exception): array
    {
        return [
            'error' => self::ERROR_TYPE,
            'description' => $exception->getMessage(),
            'details' => [],
            'code' => $exception->getCode(),
        ];
    }
}
