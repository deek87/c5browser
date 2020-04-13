<?php

namespace Codeception\Module\Traits;

use Codeception\Exception\ModuleException;

trait PackageTrait
{
    public function installPackage($packageName, $packageHandle = null, $timeout = 30)
    {
        $this->amOnPage('/index.php/dashboard/extend/install');
        if (!empty($packageHandle)) {
            $this->seeElement($this->getPathFromLocator('packageInstallLinkWithHandle', ['package_handle' => $packageHandle]));
            $this->click($this->getPathFromLocator('packageInstallLinkWithHandle', ['package_handle' => $packageHandle]));
        } else {
            $this->seeElement($this->getPathFromLocator('packageInstallLink', ['package_name' => $packageName]));
            $this->click($this->getPathFromLocator('packageInstallLink', ['package_name' => $packageName]));
        }

        $this->waitForElement($this->getPathFromLocator('resultAlertInfo'), $timeout);
        $this->seeElement($this->getPathFromLocator('packageDetailsLink', ['package_name' => $packageName]));
    }

    public function uninstallPackage($packageName, $timeout = 30)
    {
        $this->amOnPage('/index.php/dashboard/extend/install');
        $this->seeElement($this->getPathFromLocator('packageDetailsLink', ['package_name' => $packageName]));
        $this->click($this->getPathFromLocator('packageDetailsLink', ['package_name' => $packageName]));
        $this->waitForElement($this->getPathFromLocator('packageDescriptionBox', ['package_name' => $packageName]), 30);
        $this->click($this->getPathFromLocator('dashboardFormLink', ['button_text' => 'Uninstall Package']));
        $this->waitForElement($this->getPathFromLocator('packageUninstallAlert'), $timeout);
        $this->click($this->getPathFromLocator('dashboardFormButton', ['button_text' => 'Uninstall']));
        $this->waitForElement($this->getPathFromLocator('resultAlertInfo'), $timeout);
        $this->seeElement($this->getPathFromLocator('packageInstallLink', ['package_name' => $packageName]));
    }

    /**
     * Checks if the correct package details are installed.
     * $packageName is a string of the packagename
     * $detailsToCheck is an array of arrays containing key value pairs such as the following:
     * ItemToCheck => expectedItem numbers.
     *
     * example:
     * BlockTypes => 1
     * SinglePages => 2
     * Jobs=>3
     *
     * @param string $packageName
     * @param array  $detailsToCheck
     *
     * @throws ModuleException
     */
    public function checkPackageDetails($packageName, $detailsToCheck = ['BlockTypes' => 1, 'SinglePages' => 1])
    {
        $this->amOnPage('/index.php/dashboard/extend/install');
        $this->seeElement($this->getPathFromLocator('packageDetailsLink', ['package_name' => $packageName]));
        $this->click($this->getPathFromLocator('packageDetailsLink', ['package_name' => $packageName]));
        $this->waitForElement($this->getPathFromLocator('packageDescriptionBox', ['package_name' => $packageName]), 30);
        if (!is_array($detailsToCheck) || empty($detailsToCheck)) {
            throw new ModuleException('$detailsToCheck must be an array of key value pairs with at least 1 key value pair.');
        }
        foreach ($detailsToCheck as $element => $expected) {
            $this->seeNumberOfElements($this->getPathFromLocator('packageDetails'.$element), $expected);
        }
    }
}
