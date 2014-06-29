<?php

namespace Bangpound\Assetic;

use Bangpound\Pimple\Provider\AsseticServiceProvider;
use Pimple\Container as BaseContainer;
use Symfony\Component\Config\Loader\LoaderInterface;

class Container extends BaseContainer
{
    public function __construct(LoaderInterface $loader)
    {
        $parameters = $loader->load('assetic.yml');
        parent::__construct($parameters['parameters']);
        $this->register(new AsseticServiceProvider());
        foreach ($parameters['parameters']['providers'] as $class) {
            $this->register(new $class());
        }
    }
}
