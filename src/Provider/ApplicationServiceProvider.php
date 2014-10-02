<?php

namespace Bangpound\Assetic\Provider;

use Bangpound\Assetic\Console\PimpleHelper;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Spork\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\ArgvInput;

class ApplicationServiceProvider implements ServiceProviderInterface
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
        $pimple['console.input'] = function () {
            return new ArgvInput();
        };
        $pimple['pimple_helper'] = function ($c) {
            return new PimpleHelper($c);
        };
        $pimple->extend('console', function (Application $app, Container $c) {
            $app->getHelperSet()->set($c['pimple_helper']);
              $ids = preg_grep("/^[a-z0-9_.]+?\.command$/", $c->keys());

              $app->addCommands(array_map(function ($id) use ($c) {
                      return $c[$id];
                  }, $ids));

              return $app;
        });

        $pimple['paths'] = function ($c) {
            return array(
                $c['console.input']->getParameterOption('--working-dir'),
                getcwd(),
                getcwd().'/conf',
            );
        };

        $pimple['app.help.command'] = function ($c) {
            return new HelpCommand();
        };
        $pimple['app.list.command'] = function ($c) {
            return new ListCommand();
        };
        $pimple['dispatcher'] = function ($c) {
            return new EventDispatcher();
        };
    }
}
