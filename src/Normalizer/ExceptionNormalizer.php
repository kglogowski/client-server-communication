<?php

namespace CSC\Normalizer;

/**
 * Class ExceptionNormalizer
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class ExceptionNormalizer implements ExceptionNormalizerInterface
{
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
