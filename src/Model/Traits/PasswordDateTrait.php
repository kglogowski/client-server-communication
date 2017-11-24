<?php

namespace CSC\Model\Traits;

use CSC\Component\Decorator\DateTime\DateTimeDecorator;
use CSC\Component\Factory\DateTimeImmutableStaticFactory;
use JMS\Serializer\Annotation as JMS;

/**
 * Class PasswordDateTrait
 */
trait PasswordDateTrait
{
    /**
     * Data wprowadzenia hasła
     *
     * @var \DateTimeInterface
     *
     * @JMS\Type("string")
     * @JMS\Groups({"Get"})
     * @JMS\Accessor(setter="setPasswordDate", getter="getPasswordDateAsString")
     */
    protected $passwordDate;

    /**
     * @return \DateTimeInterface|null
     */
    public function getPasswordDate()
    {
        try {
            return DateTimeImmutableStaticFactory::create($this->passwordDate);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getPasswordDateAsString(): string
    {
        $passwordDate = $this->getPasswordDate();

        if (null === $passwordDate) {
            return '';
        }

        return (new DateTimeDecorator())->format($this->getPasswordDate());
    }

    /**
     * @param \DateTimeInterface|string $passwordDate
     *
     * @return $this
     */
    public function setPasswordDate($passwordDate)
    {
        if (null != $passwordDate) {
            $this->passwordDate = DateTimeImmutableStaticFactory::create($passwordDate);
        }

        return $this;
    }
}