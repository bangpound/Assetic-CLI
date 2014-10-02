<?php

namespace Bangpound\Assetic\Console;

use Brick\PimpleAware;
use Symfony\Component\Console\Helper\Helper;
use Pimple\Container;

/**
 * Provides access to a pimple instance.
 *
 * @package Flint
 */
class PimpleHelper extends Helper implements PimpleAware
{
    protected $pimple;

    /**
     * {@inheritDoc}
     */
    public function __construct(Container $pimple = null)
    {
        $this->setContainer($pimple);
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(Container $pimple = null)
    {
        $this->pimple = $pimple;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer()
    {
        return $this->pimple;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'pimple';
    }
}
