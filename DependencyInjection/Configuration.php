<?php

/*
 * This file is part of the Ivory CKEditor package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\CKEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = $this->createTreeBuilder();
        $treeBuilder
            ->root('ivory_ck_editor')
            ->children()
                ->booleanNode('enable')->end()
                ->booleanNode('async')->end()
                ->booleanNode('auto_inline')->end()
                ->booleanNode('inline')->end()
                ->booleanNode('autoload')->end()
                ->booleanNode('jquery')->end()
                ->booleanNode('require_js')->end()
                ->booleanNode('input_sync')->end()
                ->scalarNode('base_path')->end()
                ->scalarNode('js_path')->end()
                ->scalarNode('jquery_path')->end()
                ->scalarNode('default_config')->end()
                ->append($this->createConfigsNode())
                ->append($this->createPluginsNode())
                ->append($this->createStylesNode())
                ->append($this->createTemplatesNode())
                ->append($this->createFilebrowsersNode())
                ->append($this->createToolbarsNode())
            ->end();

        return $treeBuilder;
    }

    /**
     * @return NodeDefinition
     */
    private function createConfigsNode()
    {
        return $this->createNode('configs')
            ->normalizeKeys(false)
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->normalizeKeys(false)
                ->useAttributeAsKey('name')
                ->prototype('variable')->end()
            ->end();
    }

    /**
     * @return NodeDefinition
     */
    private function createPluginsNode()
    {
        return $this->createNode('plugins')
            ->normalizeKeys(false)
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('path')->end()
                    ->scalarNode('filename')->end()
                ->end()
            ->end();
    }

    /**
     * @return NodeDefinition
     */
    private function createStylesNode()
    {
        return $this->createNode('styles')
            ->normalizeKeys(false)
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')->end()
                        ->scalarNode('type')->end()
                        ->scalarNode('widget')->end()
                        ->variableNode('element')->end()
                        ->arrayNode('styles')
                            ->normalizeKeys(false)
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('attributes')
                            ->normalizeKeys(false)
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @return NodeDefinition
     */
    private function createTemplatesNode()
    {
        return $this->createNode('templates')
            ->normalizeKeys(false)
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('imagesPath')->end()
                    ->arrayNode('templates')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('title')->end()
                                ->scalarNode('image')->end()
                                ->scalarNode('description')->end()
                                ->scalarNode('html')->end()
                                ->scalarNode('template')->end()
                                ->arrayNode('template_parameters')
                                    ->normalizeKeys(false)
                                    ->useAttributeAsKey('name')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @return NodeDefinition
     */
    private function createFilebrowsersNode()
    {
        return $this->createNode('filebrowsers')
            ->useAttributeAsKey('name')
            ->prototype('scalar')
            ->end();
    }

    /**
     * @return NodeDefinition
     */
    private function createToolbarsNode()
    {
        return $this->createNode('toolbars')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('configs')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('variable')->end()
                    ->end()
                ->end()
                ->arrayNode('items')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('variable')->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param string $name
     *
     * @return NodeDefinition
     */
    private function createNode($name)
    {
        return $this->createTreeBuilder()->root($name);
    }

    /**
     * @return TreeBuilder
     */
    private function createTreeBuilder()
    {
        return new TreeBuilder();
    }
}
