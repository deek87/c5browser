<?php


namespace Codeception\Module\Locators\Concrete5;


use Codeception\Module\Locators\AbstractLocator;

class BaseInstallLocators extends AbstractLocator
{

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'base_install';
    }
}