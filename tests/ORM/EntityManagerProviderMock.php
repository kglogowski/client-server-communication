<?php

namespace CSC\Tests\ORM;

use CSC\Server\Provider\EntityManagerProvider;
use CSC\Tests\Repository\AbstractTestRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

/**
 * Class EntityManagerProviderMock
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class EntityManagerProviderMock extends TestCase
{
    /**
     * @param AbstractTestRepository $repository
     *
     * @return EntityManagerProvider
     */
    public function getEntityManagerProvider(AbstractTestRepository $repository): EntityManagerProvider
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->setMethods([
                'getRepository'
            ])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository))
        ;

        $entityManagerProvider = new EntityManagerProvider();

        /** @var EntityManager $entityManager */
        $this->assertInstanceOf(EntityManager::class, $entityManager);

        /** @var EntityManager $entityManager */
        $entityManagerProvider->setEntityManager($entityManager);

        return $entityManagerProvider;
    }
}