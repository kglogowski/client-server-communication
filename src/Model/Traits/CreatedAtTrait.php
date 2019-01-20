<?php

namespace CSC\Model\Traits;

use CSC\Util\DateTime\DateTimeDecorator;
use CSC\Util\DateTime\Factory\DateTimeImmutableStaticFactory;
use JMS\Serializer\Annotation as JMS;

/**
 * Trait CreatedAtTrait
 */
trait CreatedAtTrait
{
    /**
     * Data utworzenia
     *
     * @var \DateTimeInterface
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Get"})
     * @JMS\Accessor(setter="setCreatedAt", getter="getCreatedAtAsString")
     */
    protected $createdAt;

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        try {
            return DateTimeImmutableStaticFactory::create($this->createdAt);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getCreatedAtAsString(): string
    {
        if (null === $this->getCreatedAt()) {
            return '';
        }

        return (new DateTimeDecorator())->format($this->getCreatedAt());
    }

    /**
     * @param \DateTimeInterface|string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = DateTimeImmutableStaticFactory::create($createdAt);

        return $this;
    }
}