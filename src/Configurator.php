<?php

namespace Bangpound\Assetic;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Configurator
{
    private $loader;

    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    public function configure(Container $pimple, $resource)
    {
        $parameters = $this->loader->load($resource);

        foreach ($parameters as $k => $v) {
            $pimple->offsetSet($k, $v);
        }
    }

    public function configureFromPath(Container $pimple, $resource, $path)
    {
        $object = $this->loader->load($resource);

        $accesor = PropertyAccess::createPropertyAccessor();
        $parameters = $accesor->getValue($object, $path);

        foreach ($parameters as $k => $v) {
            $pimple->offsetSet($k, $v);
        }
    }
}
