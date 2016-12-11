<?php

namespace PDFTronBundle\DependencyInjection;


use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PDFTronExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }

        // Set as parameters.
        $container->setParameter('pdf_tron.pdf_directory', $config['pdf_directory']);
        $container->setParameter('pdf_tron.xod_directory', $config['xod_directory']);
        $container->setParameter('pdf_tron.image_directory', $config['image_directory']);
    }

}