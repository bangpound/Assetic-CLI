<?php

namespace Bangpound\Assetic;

use Cilex\Provider\Console\ContainerAwareApplication as BaseApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends BaseApplication
{
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);
        $this->getDefinition()->addOption(new InputOption('--config', '-c', InputOption::VALUE_NONE, 'Configuration file'));
    }
}
