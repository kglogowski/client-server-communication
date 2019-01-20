<?php

namespace CSC\Util\DateTime\Factory;

use CSC\Util\DateTime\DateTimeDecorator;

/**
 * Class DateTimeImmutableStaticFactory
 */
class DateTimeImmutableStaticFactory
{
    /**
     * @param \DateTimeInterface|string $dateTime
     *
     * @return \DateTimeImmutable
     *
     * @throws \TypeError
     */
    public static function create($dateTime): \DateTimeImmutable
    {
        if ($dateTime instanceof \DateTimeImmutable) {
            return $dateTime;
        }

        if ($dateTime instanceof \DateTime) {
            return \DateTimeImmutable::createFromMutable($dateTime);
        }

        if (false === is_string($dateTime)) {
            throw new \InvalidArgumentException('Invalid DateTime format given.');
        }

        try {
            return \DateTimeImmutable::createFromFormat(DateTimeDecorator::DATE_FORMAT, $dateTime);
        } catch (\TypeError $e) {
            throw new \TypeError(sprintf('Date should have format: %s', DateTimeDecorator::DATE_FORMAT));
        }

    }
}