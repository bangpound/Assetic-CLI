<?php

namespace Bangpound\Assetic;

use Bangpound\Assetic\Provider\ApplicationServiceProvider;
use Pimple\Container as BaseContainer;
use Silex\Provider\MonologServiceProvider;

class Container extends BaseContainer
{
    public function __construct($rootDir, $debug = false, array $values = array())
    {
        parent::__construct(array('root_dir' => $rootDir, 'debug' => $debug) + $values);
        $this->register(new ApplicationServiceProvider(), array(
            'tacker.options' => array(
                'cache_dir' => '/tmp',
            ),
        ));
        $this->register(new MonologServiceProvider());
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
