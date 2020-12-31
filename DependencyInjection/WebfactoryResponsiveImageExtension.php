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
    public function load(array $configs, ContainerBuilder $container)
    {
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
        $originalConfig = $container->getExtensionConfig('jb_phumbor')[0];
        $resultingConfig = $this->addConfigForEnvironment($originalConfig, null);

        $environment = $container->getParameter('kernel.environment');
        if (in_array($environment, ['development', 'testing', 'test'], true)) {
            $resultingConfig = $this->addConfigForEnvironment($resultingConfig, $environment);
        }

        $container->prependExtensionConfig('jb_phumbor', $resultingConfig);
    }

    private function addConfigForEnvironment(array $originalConfig, ?string $environment): array
    {
        $fileName = 'jb_phumbor-default-config'.($environment ? '_'.$environment : '').'.yaml';
        $configToAdd = Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/'.$fileName))['jb_phumbor'];

        return is_array($configToAdd)
            ? array_replace_recursive($originalConfig, $configToAdd)
            : $originalConfig;
    }
}
