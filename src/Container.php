<?php

namespace Bangpound\Assetic;

use Bangpound\Assetic\Provider\ApplicationServiceProvider;
use Bangpound\Assetic\Provider\ConfigServiceProvider;
use Cilex\Provider\Console\ConsoleServiceProvider;
use Bangpound\Pimple\Container as BaseContainer;

class Container extends BaseContainer
{
    public function __construct($rootDir, $debug = false, array $values = array())
    {
        parent::__construct(array('root_dir' => $rootDir, 'debug' => $debug) + $values);
        $this->register(new ConsoleServiceProvider(), array(
            'console.class' => 'Bangpound\\Assetic\\Application',
            'console.name' => 'Assetic',
            'console.version' => '1.0.x-dev',
        ));
        $this->register(new ApplicationServiceProvider());
        $this->register(new ConfigServiceProvider(), array(
            'conf_dir' => self::getHomeDir(),
            'tacker.options' => array(
                'cache_dir' => '/tmp',
            ),
        ));
    }

    protected static function getHomeDir()
    {
        $home = getenv('ASSETIC_HOME');
        if (!$home) {
            if (!getenv('HOME')) {
                throw new \RuntimeException('The HOME or ASSETIC_HOME environment variable must be set for composer to run correctly');
            }
            $home = rtrim(getenv('HOME'), '/').'/.assetic';
        }

        return $home;
    }
}
