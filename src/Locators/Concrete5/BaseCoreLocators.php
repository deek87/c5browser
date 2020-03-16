<?php


namespace Codeception\Module\Locators\Concrete5;


use Codeception\Module\Locators\AbstractLocator;

/**
 * Contains all the common dashboard locators between versions 5.7 / 8 / 9
 * Class BaseDashboardLocators
 * @package Codeception\Module\Locators\Concrete5
 * @author derekcameron
 */
class BaseCoreLocators extends AbstractLocator
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'base_core';
    }

}