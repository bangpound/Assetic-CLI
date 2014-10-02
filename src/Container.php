<?php

namespace Bangpound\Assetic;

use Bangpound\Assetic\Provider\ApplicationServiceProvider;
use Pimple\Container as BaseContainer;

class Container extends BaseContainer
{
    public function __construct(array $values = array())
    {
        // assetic.yml contains all container configuration.
        parent::__construct($values);

        $this->register(new ApplicationServiceProvider());
    }
}
