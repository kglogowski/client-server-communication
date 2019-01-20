<?php

namespace CSC\Model\Traits;

use CSC\Util\DateTime\DateTimeDecorator;
use CSC\Util\DateTime\Factory\DateTimeImmutableStaticFactory;
use JMS\Serializer\Annotation as JMS;

/**
 * Class LastLoginAtTrait
 */
trait LastLoginAtTrait
{
    /**
     * Ostatnie logowanie
     *
     * @var \DateTimeInterface
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Get"})
     * @JMS\Accessor(setter="setLastLoginAt", getter="getLastLoginAtAsString")
     */
    protected $lastLoginAt;

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastLoginAt()
    {
        try {
            return DateTimeImmutableStaticFactory::create($this->lastLoginAt);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getLastLoginAtAsString(): string
    {
        if (null !== $this->getLastLoginAt()) {
            return (new DateTimeDecorator())->format($this->getLastLoginAt());
        } else {
            return '';
        }
    }

    /**
     * @param \DateTimeInterface|string $lastLoginAt
     *
     * @return $this
     */
    public function setLastLoginAt($lastLoginAt)
    {
        if (null != $lastLoginAt) {
            $this->lastLoginAt = DateTimeImmutableStaticFactory::create($lastLoginAt);
        }

        return $this;
    }
}