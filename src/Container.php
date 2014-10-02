<?php

namespace Bangpound\Assetic;

use Bangpound\Pimple\Provider\AsseticServiceProvider;
use Pimple\Container as BaseContainer;

class Container extends BaseContainer
{
    public function __construct(array $values = array())
    {
        $parameters = $loader->load('assetic.yml');
        parent::__construct($parameters['parameters']);
        $this->register(new AsseticServiceProvider());
        foreach ($parameters['parameters']['providers'] as $class) {
            $this->register(new $class());
        }
        // assetic.yml contains all container configuration.
        parent::__construct($values);
    }
}
