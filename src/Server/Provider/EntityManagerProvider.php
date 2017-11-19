<?php

namespace CSC\Server\Provider;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityManagerProvider
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class EntityManagerProvider
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}