<?php

namespace Bangpound\Assetic;

class ContainerHelper implements \Symfony\Component\Console\Helper\HelperInterface
{
    /**
     * Sets the helper set associated with this helper.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet A HelperSet instance
     *
     * @api
     */
    public function setHelperSet(\Symfony\Component\Console\Helper\HelperSet $helperSet = null)
    {
        // TODO: Implement setHelperSet() method.
    }

    /**
     * Gets the helper set associated with this helper.
     *
     * @return \Symfony\Component\Console\Helper\HelperSet A HelperSet instance
     *
     * @api
     */
    public function getHelperSet()
    {
        // TODO: Implement getHelperSet() method.
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    public function getName()
    {
        return 'container';
    }
}
