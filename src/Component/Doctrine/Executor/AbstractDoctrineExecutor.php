<?php

namespace CSC\Component\Doctrine\Executor;

use CSC\Component\Doctrine\Provider\EntityManagerProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractExecutor
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
abstract class AbstractDoctrineExecutor
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * AbstractSimpleExecutor constructor.
     *
     * @param EntityManagerProvider $entityManagerProvider
     */
    public function __construct(EntityManagerProvider $entityManagerProvider)
    {
        $this->entityManager = $entityManagerProvider->getEntityManager();
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}