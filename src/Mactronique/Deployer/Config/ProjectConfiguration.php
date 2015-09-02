<?php

namespace Mactronique\Deployer\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class ProjectConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('deployer');

        $rootNode
                ->children()
                    ->arrayNode('projects')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('url')->isRequired()->end()
                                ->scalarNode('type')->defaultValue('svn')->end()
                                ->booleanNode('enable')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('credentials')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('username')->isRequired()->end()
                                ->scalarNode('password')->defaultValue('')->end()
                                ->booleanNode('svn_cache_credentials')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
