<?php

namespace CSC\Model\Traits;

use CSC\Component\Decorator\DateTime\DateTimeDecorator;
use CSC\Component\Factory\DateTimeImmutableStaticFactory;
use JMS\Serializer\Annotation as JMS;

/**
 * Class UpdatedAtTrait
 */
trait UpdatedAtTrait
{
    /**
     * Data aktualizacji
     *
     * @var \DateTimeInterface
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Get"})
     * @JMS\Accessor(setter="setUpdatedAt", getter="getUpdatedAtAsString")
     */
    protected $updatedAt;

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        try {
            return DateTimeImmutableStaticFactory::create($this->updatedAt);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getUpdatedAtAsString(): string
    {
        if (null === $this->getUpdatedAt()) {
            return '';
        }

        return (new DateTimeDecorator())->format($this->getUpdatedAt());
    }

    /**
     * @param \DateTimeInterface|string $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = DateTimeImmutableStaticFactory::create($updatedAt);

        return $this;
    }
}