<?php

declare(strict_types=1);

/*
 * This file is part of TheCadien/SuluNewsBundle.
 *
 * by Oliver Kossin and contributors.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Havex\Bundle\SuluNewsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;
use Havex\Bundle\SuluNewsBundle\Repository\NewsRepository;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sulu_havex_news');
        $root = $treeBuilder->getRootNode();

        $root->children()
            ->arrayNode('objects')
            ->addDefaultsIfNotSet()
            ->children()
            ->arrayNode('news')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('model')->defaultValue(HavexHavexNews::class)->end()
            ->scalarNode('repository')->defaultValue(NewsRepository::class)->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
