<?php

namespace Webfactory\ResponsiveImageBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class WebfactoryResponsiveImageExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $config, ContainerBuilder $container)
    {
        $locator = new FileLocator(__DIR__ . '/../Resources/config');
        $xmlLoader = new XmlFileLoader($container, $locator);
        $xmlLoader->load('services.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $this->prependJbPhumborConfiguration($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function prependJbPhumborConfiguration(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles['JbPhumborBundle'])) {
            return;
        }

        // Phumbor doesn't merge multiple configs, i.e. we have to consider only the first one
        $actualConfig = $container->getExtensionConfig('jb_phumbor')[0];
        $defaultConfig = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/jb_phumbor-default-config.yaml'))['jb_phumbor'];
        $resultingConfig = array_replace_recursive($defaultConfig, $actualConfig);

        $container->prependExtensionConfig('jb_phumbor', $resultingConfig);
    }
}
