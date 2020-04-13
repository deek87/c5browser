<?php

namespace C5Browser\Test\Install;

use AcceptanceTester;

class InstallCest
{
    /**
     * @throws \Exception
     */
    public function installCheck(AcceptanceTester $I)
    {
        $I->installConcrete5();
        $I->comment('I click on edit your site button');
        $I->clickWithLeftButton($I->getPathFromLocator('primaryButton'));
        $I->comment('I close the help UI box.');
        $I->waitForElement($I->getPathFromLocator('uiDialogBox'), 30);
        $I->click($I->getPathFromLocator('uiDialogClose'));
    }
}
