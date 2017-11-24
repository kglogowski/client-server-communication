<?php

namespace CSC\Component\Decorator\DateTime;

/**
 * Class PlainDateTimeDecorator
 */
class PlainDateTimeDecorator implements DateTimeDecoratorInterface
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

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
