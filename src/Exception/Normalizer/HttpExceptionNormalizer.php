<?php

namespace CSC\Exception\Normalizer;

/**
 * Class HttpExceptionNormalizer
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class HttpExceptionNormalizer implements ExceptionNormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize(\Exception $exception): array
    {
        return [
            self::KEY_ERROR => self::ERROR_TYPE,
            self::KEY_DESCRIPTION => $exception->getMessage(),
            self::KEY_DETAILS => [],
            self::KEY_CODE => $exception->getCode(),
        ];
    }
}
