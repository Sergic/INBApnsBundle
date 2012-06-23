<?php

namespace INB\ApnsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class INBApnsExtension extends Extension
{
	public function load(array $config, ContainerBuilder $container)
	{
        if (!$container->hasDefinition('inb_apns')) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('services.yml');
        }
	}
	
	public function getXsdValidationBasePath()
	{
		return __DIR__ . '/../Resources/config/';
	}
	
	public function getNamespace()
	{
		return 'http://sergic.me/symfony/schema/';
	}

	public function getAlias()
	{
		return 'inb_apns';
	}

}
