<?php
/**
 * This file is part of the IrishDan\PDFTronBundle package.
 *
 * (c) Daniel Byrne <danielbyrne@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source
 * code.
 */

namespace IrishDan\PDFTronBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package PDFTronBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pdf_tron');

        $rootNode
            ->children()
                ->scalarNode('pdf_directory')
                    ->defaultValue('pdf')
                ->end()
                ->scalarNode('xod_directory')
                    ->defaultValue('web/xod')
                ->end()
                ->scalarNode('image_directory')
                    ->defaultValue('web/image')
                ->end()
                ->arrayNode('options_sets')
                    ->prototype('array')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}