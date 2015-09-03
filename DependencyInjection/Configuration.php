<?php

namespace Kupids\Bundle\FacebookRestServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('facebook_rest_server');

        $rootNode
            ->children()
                ->scalarNode('app_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('secret_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('firewall')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->arrayNode('permissions')
                    ->children()
                        ->booleanNode('email')
                            ->defaultTrue()
                            ->end()
                        ->booleanNode('user_birthday')
                            ->defaultTrue()
                            ->end()
                        ->booleanNode('user_gender')
                            ->defaultNull()
                            ->end()
                        ->booleanNode('user_location')
                            ->defaultNull()
                            ->end()
                        ->booleanNode('user_photo')
                            ->defaultTrue()
                            ->end()
                        ->booleanNode('album')
                            ->defaultNull()
                            ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
