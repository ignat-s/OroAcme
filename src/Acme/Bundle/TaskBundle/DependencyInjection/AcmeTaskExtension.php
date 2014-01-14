<?php

namespace Acme\Bundle\TaskBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class AcmeTaskExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->prependExtensionConfig('acme_task', $config);

        $loader->load('services.yml');
    }
}
