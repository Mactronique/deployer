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
                    ->booleanNode('enable_email')
                        ->defaultFalse()
                    ->end()
                    ->scalarNode('svn_path')
                        ->defaultValue(null)
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
