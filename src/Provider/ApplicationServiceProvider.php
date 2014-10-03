<?php

namespace Bangpound\Assetic\Provider;

use G\Yaml2Pimple\ContainerBuilder;
use G\Yaml2Pimple\YamlFileLoader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ApplicationServiceProvider implements ServiceProviderInterface
{
    const COMMAND_MATCH = '/^[a-z0-9_.]+?\.command$/';

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
        /**
         * Console parameters and services.
         */
        $pimple['console.class']   = 'Symfony\\Component\\Console\\Application';
        $pimple['console.name']    = 'Assetic';
        $pimple['console.version'] = '1.0.x-dev';
        $pimple['console.input']   = function () { return new ArgvInput(); };

        $pimple['config.builder'] = function ($c) {
            return new ContainerBuilder($c);
        };
        $pimple['config.locator'] = function ($c) {
            return new FileLocator(__DIR__, $c['conf'], __DIR__.'/conf');
        };
        $pimple['config.loader']  = $pimple->factory(function ($c) {
            return new YamlFileLoader($c['config.builder'], $c['config.locator']);
        });

        /**
         * These commands fell off and probably don't actually need to be here.
         */
        $pimple['app.help.command'] = function () { return new HelpCommand(); };
        $pimple['app.list.command'] = function () { return new ListCommand(); };

        /**
         *
         * @return EventDispatcher
         */
        $pimple['dispatcher'] = function ($c) { return new EventDispatcher(); };
        $pimple->extend('dispatcher', function (EventDispatcherInterface $eventDispatcher, Container $c) {
            $c['console']->setContainer($c); $c['console']->setDispatcher($eventDispatcher);

            return $eventDispatcher;
        });

        /**
         * Creates the console application that is used by the front controller.
         *
         * @param Container $c
         * @return Application
         */
        $pimple['console'] = function (Container $c) {
            return new $c['console.class']($c['console.name'], $c['console.version']);
        };
        $pimple->extend('console', function (Application $app, Container $c) {
            $ids = preg_grep("", $c->keys());

            $app->addCommands(array_map(function ($id) use ($c) {
                return $c[$id];
            }, $ids));

            return $app;
        });
    }
}
