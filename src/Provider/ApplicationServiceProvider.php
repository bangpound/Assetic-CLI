<?php

namespace Bangpound\Assetic\Provider;

use Cilex\Provider\Console\ConsoleServiceProvider;
use Pimple\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

class ApplicationServiceProvider extends ConsoleServiceProvider
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
         * Additional console parameters and services.
         */
        $pimple['console.input'] =
        /**
         * @return ArgvInput
         */
        function () { return new ArgvInput(); };

        $pimple->extend('console', function (Application $app, Container $c) {
            $app->setDispatcher($c['dispatcher']);
            $ids = preg_grep(self::COMMAND_MATCH, $c->keys());

            $app->addCommands(array_map(function ($id) use ($c) {
                return $c[$id];
            }, $ids));

            return $app;
        });
    }
}
