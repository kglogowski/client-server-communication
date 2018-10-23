<?php

namespace CSC\Component\Decorator\DateTime;

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