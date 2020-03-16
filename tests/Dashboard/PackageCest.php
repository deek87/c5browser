<?php


namespace Concrete\UITests\Page;

use AcceptanceTester;


class PackageCest {


    public function _before(AcceptanceTester $I)
    {
        $I->login();
    }

    public function installPackage(AcceptanceTester $I) {
        $I->installPackage('DK Test Package');
        $I->checkPackageDetails('DK Test Package',['BlockTypes'=>1, 'SinglePages'=>1]);
    }

    public function removePackage(AcceptanceTester $I) {
        $I->uninstallPackage('DK Test Package', 30);
    }
}
