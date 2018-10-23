<?php

namespace CSC\Component\Normalizer;

/**
 * Interface NormailizeAware
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