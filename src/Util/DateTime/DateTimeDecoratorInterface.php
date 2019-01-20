<?php

namespace CSC\Util\DateTime;

/**
 * Interface DateTimeDecoratorInterface
 */
interface DateTimeDecoratorInterface
{
    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
     */
    public function format(\DateTimeInterface $dateTime): string;
}