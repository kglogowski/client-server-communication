<?php

namespace CSC\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    const
        INDEX_TOKEN_LIFETIME        = 'token_lifetime',
        INDEX_TOKEN_SECRET          = 'token_secret',
        INDEX_LINK_TOKEN_LIFETIME   = 'link_token_lifetime'
    ;

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('csc');

        $rootNode
            ->children()
                ->integerNode(self::INDEX_LINK_TOKEN_LIFETIME)->defaultValue(3600)
                ->end()
            ->end()
            ->children()
                ->integerNode(self::INDEX_TOKEN_LIFETIME)->defaultValue(3600)
                ->end()
            ->end()
            ->children()
                ->variableNode(self::INDEX_TOKEN_SECRET)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
