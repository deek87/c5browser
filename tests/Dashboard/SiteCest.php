<?php


namespace C5Browser\Test\Page;

use AcceptanceTester;

class SiteCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->login();
    }

    public function setSiteName(AcceptanceTester $I)
    {
        $I->amOnPage('/index.php/dashboard/system/basics/name');
        $I->fillField($I->getPathFromLocator('siteName'), 'Testing Site');
        $I->clickWithLeftButton($I->getPathFromLocator('dashboardSubmitButton'));
        $I->waitForElementVisible($I->getPathFromLocator('resultAlertInfo'), 15);
        $I->amOnPage('/index.php');
        $I->wait(2);
        $I->canSeeInTitle('Testing Site');
    }

}