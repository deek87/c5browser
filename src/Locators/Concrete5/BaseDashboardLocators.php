<?php


namespace Codeception\Module\Locators\Concrete5;


use Codeception\Module\Locators\AbstractLocator;

class BaseDashboardLocators extends AbstractLocator
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'base_dashboard';
    }

}