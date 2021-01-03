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
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['JbPhumborBundle'])) {
            return;
        }

        $this->prependConfigFile(__DIR__.'/../Resources/config/jb_phumbor-default-config.yaml', $container);

        $environment = $container->getParameter('kernel.environment');
        if (in_array($environment, ['development', 'testing', 'test'], true)) {
            $this->prependConfigFile(__DIR__."/../Resources/config/jb_phumbor-default-config_$environment.yaml", $container);
        }
    }

    private function prependConfigFile(string $filename, ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('jb_phumbor', Yaml::parse(file_get_contents($filename))['jb_phumbor']);
    }
}
