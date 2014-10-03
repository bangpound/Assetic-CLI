<?php

namespace Bangpound\Assetic\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ProviderServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple An Container instance
     */
    public function register(Container $pimple)
    {
    }
}
