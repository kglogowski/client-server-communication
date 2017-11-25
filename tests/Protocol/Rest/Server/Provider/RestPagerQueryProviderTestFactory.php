<?php

namespace CSC\Tests\Protocol\Rest\Server\Provider;

use CSC\Component\Provider\UserProvider;
use CSC\Protocol\Rest\Server\Provider\RestPagerQueryProvider;
use CSC\Tests\ORM\EntityManagerProviderMock;
use CSC\Tests\Protocol\Rest\Builder\RestPagerQueryBuilderTestFactory;
use CSC\Tests\Protocol\Rest\Server\DataObject\DataObjectConfigurationTestFactory;
use CSC\Tests\Repository\ModelMockRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class RestPagerQueryProviderTestFactory
 *
 * @author Krzysztof Głogowski <k.glogowski2@gmail.com>
 */
class RestPagerQueryProviderTestFactory
{
    public static function create(): RestPagerQueryProvider
    {
        return new RestPagerQueryProvider(
            (new EntityManagerProviderMock())->getEntityManagerProvider(new ModelMockRepository()),
            RestPagerQueryBuilderTestFactory::create(),
            new UserProvider(new TokenStorage()),
            DataObjectConfigurationTestFactory::createPager()
        );
    }
}