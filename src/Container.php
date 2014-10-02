<?php

namespace Bangpound\Assetic;

use Bangpound\Assetic\Provider\ApplicationServiceProvider;
use Brick\Provider\TackerServiceProvider;
use Cilex\Provider\Console\ConsoleServiceProvider;
use Pimple\Container as BaseContainer;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Container extends BaseContainer
{
    public function __construct($rootDir, $debug = false, array $values = array())
    {
        parent::__construct(array('root_dir' => $rootDir, 'debug' => $debug) + $values);
        $this->register(new ConsoleServiceProvider(), array(
            'console.name'    => 'Assetic',
            'console.class'   => 'Bangpound\\Assetic\\Application',
            'console.version' => '1.0.x-dev',
          ));
        $this->register(new ApplicationServiceProvider());
        $this->register(new TackerServiceProvider());
        $this->extend('tacker.config', function ($array, $c) {
              $array['paths'][] = $c['root_dir'] .'/conf';

              return $array;
          });

        $loader = $this['tacker.builder']->build();
        $object = $loader->load('parameters.yml');
        $this->configure($object, '[parameters]');

        $object = $loader->load('assetic.yml');

        // The configurator runs twice because the Pimple Normalizer
        // had no effect on the previous run.
        foreach ($object['providers'] as $className => $values) {
            $this->register(new $className(), (array) $values);
        }
    }

    public function configure($object, $propertyPath)
    {
        $accesor = PropertyAccess::createPropertyAccessor();
        $values = $accesor->getValue($object, $propertyPath);
        foreach ($values as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }
}
