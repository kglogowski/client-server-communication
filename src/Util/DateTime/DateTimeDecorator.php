<?php

namespace CSC\Util\DateTime;

/**
 * Class DateTimeDecorator
 */
class DateTimeDecorator implements DateTimeDecoratorInterface
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
     */
    public function format(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format(self::DATE_FORMAT);
    }
}