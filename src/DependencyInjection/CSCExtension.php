<?php

namespace CSC\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class CSCExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $this->loadDataObjectDefinition($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('builder.xml');
        $loader->load('checker.xml');
        $loader->load('controller.xml');
        $loader->load('event_listener.xml');
        $loader->load('executor.xml');
        $loader->load('factory.xml');
        $loader->load('generator.xml');
        $loader->load('manager.xml');
        $loader->load('normalizer.xml');
        $loader->load('paginator.xml');
        $loader->load('processor.xml');
        $loader->load('provider.xml');
        $loader->load('resolver.xml');
        $loader->load('security.xml');
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadDataObjectDefinition(array $config, ContainerBuilder $container)
    {
        $container->setParameter('csc.configuration', [
            Configuration::INDEX_TOKEN_LIFETIME => $config[Configuration::INDEX_TOKEN_LIFETIME],
            Configuration::INDEX_TOKEN_SECRET => $config[Configuration::INDEX_TOKEN_SECRET],
            Configuration::INDEX_USE_SSO => $config[Configuration::INDEX_USE_SSO],
            Configuration::INDEX_LINK_TOKEN_LIFETIME => $config[Configuration::INDEX_LINK_TOKEN_LIFETIME],
        ]);

        $container->setParameter('csc.pager_data_object', $config['pager_data_object']);
        $container->setParameter('csc.simple_data_object', $config['simple_data_object']);
    }
}
