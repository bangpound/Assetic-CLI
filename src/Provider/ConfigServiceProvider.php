<?php

namespace Bangpound\Assetic\Provider;

use G\Yaml2Pimple\ContainerBuilder;
use G\Yaml2Pimple\YamlFileLoader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\Config\FileLocator;

class ConfigServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple An Container instance
     */
    public function register(Container $pimple)
    {
        $pimple['config.builder'] = function ($c) {
            return new ContainerBuilder($c);
        };
        $pimple['config.locator'] = function ($c) {
            return new FileLocator(array(getcwd(), $c['conf_dir'], $c['root_dir'].'/conf'));
        };
        $pimple['config.loader']  = $pimple->factory(function ($c) {
            return new YamlFileLoader($c['config.builder'], $c['config.locator']);
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        $app['config.loader']->load($app['conf']);
    }
}
