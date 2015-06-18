<?php

namespace Kupids\Bundle\FacebookRestServerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FacebookRestServerExtension extends Extension
{
    const PREFIX = 'kpdz_facebook.rest_server';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->setParameters($container, $config);

    }

    public function setParameters(ContainerBuilder $container, array $parameters)
    {
        foreach ($parameters as $attributes => $values) {
            $container->setParameter(self::PREFIX . '.' . $attributes, $values);
            if (is_array($values) && !empty($values)) {
                foreach ($values as $key => $value) {
                    $container->setParameter(self::PREFIX . '.' . $key, $value);
                }
            }
        }
    }
}
