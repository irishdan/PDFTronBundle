<?php

namespace PDFTronBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package PDFTronBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * @var bool
     */
    private $debug;

    /**
     * Configuration constructor.
     * @param $debug
     */
    public function  __construct($debug)
    {
        $this->debug = (bool) $debug;
    }

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
            ->end()
        ;

        return $treeBuilder;
    }
}