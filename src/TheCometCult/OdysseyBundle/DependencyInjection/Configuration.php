<?php

namespace TheCometCult\OdysseyBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('the_comet_cult_odyssey');

        $rootNode
            ->children()
                ->integerNode('crew_size')->defaultValue(5)->end()
                ->arrayNode('time')
                    ->children()
                        ->integerNode('departure_delay')->defaultValue(24*60)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
