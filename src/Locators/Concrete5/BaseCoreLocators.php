<?php

namespace Codeception\Module\Locators\Concrete5;

use Codeception\Module\Locators\AbstractLocator;

/**
 * Contains all the common dashboard locators between versions 5.7 / 8 / 9
 * Class BaseDashboardLocators.
 *
 * @author derekcameron
 */
class BaseCoreLocators extends AbstractLocator
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'base_core';
    }
}
