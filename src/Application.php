<?php

namespace Bangpound\Assetic;

use Cilex\Provider\Console\ContainerAwareApplication as BaseApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends BaseApplication
{
    public function __construct(\Pimple\Container $container)
    {
        $this->setContainer($container);
        parent::__construct('Assetic', '1.0.x-dev');
        $this->setDispatcher($container['dispatcher']);
    }

    protected function getDefaultCommands()
    {
        $ids = preg_grep("/^[a-z0-9_.]+?\.command$/", $this->getContainer()->keys());
        $c = $this->getContainer();

        return array_map(function ($id) use ($c) {
            return $c[$id];
        }, $ids);
    }

    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('working-dir', null, InputOption::VALUE_OPTIONAL));
        $definition->addOption(new InputOption('no-debug', null, InputOption::VALUE_OPTIONAL));

        return $definition;
    }
}
