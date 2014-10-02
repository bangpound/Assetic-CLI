<?php

namespace Bangpound\Assetic;

use Cilex\Provider\Console\ContainerAwareApplication as BaseApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends BaseApplication
{
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('working-dir', null, InputOption::VALUE_OPTIONAL));
        $definition->addOption(new InputOption('no-debug', null, InputOption::VALUE_OPTIONAL));

        return $definition;
    }
}
