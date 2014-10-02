<?php

namespace Bangpound\Assetic\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Spork\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Tacker\LoaderBuilder;
use Tacker\Normalizer\ChainNormalizer;
use Tacker\Normalizer\PimpleNormalizer;

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
        $pimple['console.input'] = function ($c) {
            return new \Symfony\Component\Console\Input\ArgvInput();
        };
        $pimple['loader.paths'] = function ($c) {
            return array(
                $c['console.input']->getParameterOption('--working-dir'),
                getcwd(),
                getcwd() .'/conf',
            );
        };
        $pimple['debug'] = FALSE;

        $pimple['app.help.command'] = function ($c) {
            return new HelpCommand();
        };
        $pimple['app.list.command'] = function ($c) {
            return new ListCommand();
        };
        $pimple['dispatcher'] = function ($c) {
            return new EventDispatcher();
        };

        // Build the loader to include the default normalizers and also
        // the Pimple Normalizer.
        $pimple['tracker.loader'] = function (Container $c) {
            return LoaderBuilder::create($c['loader.paths'], null, $c['debug'])
                ->addDefaultNormalizers()
                ->configureNormalizers(function (ChainNormalizer $normalizer) use ($c) {
                    $normalizer->add($c['tacker.normalizer.pimple']);
                })->build();
        };
        $pimple['tacker.normalizer.pimple'] = function ($c) {
            return new PimpleNormalizer($c);
        };

        $pimple['configurator'] = function ($c) {
            $configurator = new \Bangpound\Assetic\Configurator($c['tracker.loader']);
            return $configurator;
        };
    }
}
