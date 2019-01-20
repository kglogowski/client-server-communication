<?php

namespace CSC\Exception\Normalizer;

/**
 * Interface Normalizer
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
interface Normalizer
{
    /**
     * @return array
     */
    public function normalize(): array;
}