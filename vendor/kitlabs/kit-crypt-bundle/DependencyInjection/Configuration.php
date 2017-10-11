<?php
namespace Kit\CryptBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kit_crypt');
        $rootNode->children()
                    ->scalarNode('secret_key')->cannotBeEmpty()->end()
                    ->scalarNode('secret_iv')->cannotBeEmpty()->end()
                    ->scalarNode('method')->cannotBeEmpty()->end()
                ->end();
        return $treeBuilder;
    }
}
