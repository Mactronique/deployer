<?php

namespace Mactronique\Deployer\Config;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('deployer');

        $rootNode
                ->children()
                    ->booleanNode('enable-email')
                        ->defaultFalse()
                    ->end()
                    ->scalarNode('svn-path')
                        ->defaultValue(null)
                    ->end()
                    ->arrayNode('projects')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('url')->isRequired()->end()
                                ->booleanNode('enable')
                                    ->defaultTrue()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
