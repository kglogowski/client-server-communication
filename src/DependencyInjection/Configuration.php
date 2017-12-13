<?php

namespace CSC\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    const PAGER_DATA_OBJECT_ROUTING_KEY = 'routing';
    const PAGER_DATA_OBJECT_METHODS_KEY = 'methods';
    const SIMPLE_DATA_OBJECT_UPDATABLE_KEY = 'updatable_fields';
    const SIMPLE_DATA_OBJECT_INSERTABLE_KEY = 'insertable_fields';

    const
        INDEX_TOKEN_LIFETIME        = 'token_lifetime',
        INDEX_TOKEN_SECRET          = 'token_secret',
        INDEX_USE_SSO               = 'use_sso',
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
                ->integerNode(self::INDEX_TOKEN_LIFETIME)
                ->end()
            ->end()
            ->children()
                ->variableNode(self::INDEX_TOKEN_SECRET)
                ->end()
            ->end()
            ->children()
                ->booleanNode(self::INDEX_USE_SSO)
                ->end()
            ->end()
            ->children()
                ->arrayNode('pager_data_object')
                    ->prototype('array')
                        ->children()
                            ->arrayNode(self::PAGER_DATA_OBJECT_METHODS_KEY)
                            ->isRequired()
                            ->cannotBeEmpty()
                                ->prototype('array')
                                ->cannotBeEmpty()
                                    ->children()
                                        ->arrayNode('filter')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                            ->prototype('variable')
                                            ->end()
                                        ->end()
                                        ->arrayNode('sort')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                            ->prototype('variable')
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->children()
                            ->arrayNode(self::PAGER_DATA_OBJECT_ROUTING_KEY)
                                ->children()
                                    ->variableNode('name')
                                        ->isRequired()
                                        ->cannotBeEmpty()
                                    ->end()
                                    ->arrayNode('arguments')
                                        ->prototype('variable')
                                        ->end()
                                    ->end()
                                    ->append($this->buildRoutingItems(10))
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('simple_data_object')
                    ->prototype('array')
                        ->children()
                            ->arrayNode(self::SIMPLE_DATA_OBJECT_UPDATABLE_KEY)
                                ->prototype('variable')
                                ->end()
                            ->end()
                        ->end()
                        ->children()
                            ->arrayNode(self::SIMPLE_DATA_OBJECT_INSERTABLE_KEY)
                                ->prototype('variable')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param $count
     *
     * @return NodeDefinition
     */
    private function buildRoutingItems($count)
    {
        $builder = new TreeBuilder();
        $node = $builder->root('items');
        $count = $count - 1;

        if (0 !== $count) {
            $node
                ->prototype('array')
                    ->children()
                        ->variableNode('name')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('arguments')
                            ->prototype('variable')
                            ->end()
                        ->end()
                        ->append($this->buildRoutingItems($count))
                    ->end()
                ->end()
            ;
        }

        return $node;
    }
}
