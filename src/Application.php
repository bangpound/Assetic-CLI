<?php

namespace Bangpound\Assetic;

use Symfony\Component\Console\Application as BaseApplication;
use Pimple\Container;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class Application extends BaseApplication
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct('Assetic', '1.0.x-dev');
    }

    protected function getCommandName(InputInterface $input)
    {
        return 'dump';
    }

    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = $this->container['assetic.command.dump'];

        return $commands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }

    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('working-dir', null, InputOption::VALUE_OPTIONAL));
        $definition->addOption(new InputOption('no-debug', null, InputOption::VALUE_OPTIONAL));

        return $definition;
    }
}
