<?php

namespace C5Browser\Test\Page;

use AcceptanceTester;

class AddCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->login();
    }

    public function _after(AcceptanceTester $I)
    {
        $I->setCurrentUrl($I->grabFromCurrentUrl());
    }

    public function addPage(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard');
    }

    public function addPageWithContent(AcceptanceTester $I)
    {
        $I->amOnPage('/dashboard');
    }

    public function loadNewPage(AcceptanceTester $I)
    {
        $I->seeElement('//a[@data-launch-panel="sitemap"]');
        $I->clickWithLeftButton('//a[@data-launch-panel="sitemap"]');
        $I->waitForText('New Page', 30);
        $I->click('Empty Page');
        $I->waitForElement('.ccm-toolbar-page-edit-mode-active', 30);
        $I->waitForJS('return document.readyState == "complete"', 60);
        $I->waitForJS('return !!window . jQuery && window . jQuery . active == 0;', 60);
    }

    public function addNewBlock(AcceptanceTester $I)
    {
        $I->addContentBlock('XYZ TESTING');
    }

    public function dragAndDropBlock(AcceptanceTester $I)
    {
        $I->dragAndDropImageBlock('bridge', 'Main');
        /*
         *  $I->clickWithLeftButton('.ccm-toolbar-add');
         $I->waitForText('Image');
         $I->dragAndDrop('//a[@data-panel-add-block-drag-item="block"][@title="Image"]',
             '//div[contains(@class,"ccm-area-drag-area")][text()="Empty Page Footer Area"]');
         $I->waitForElement('div.ccm-file-selector-choose-new');
         $I->clickWithLeftButton('div.ccm-file-selector-choose-new');
         $I->waitForElement('//div[contains(@class,"ccm-ui")][@data-header="file-manager"]');
         $I->waitForElement('//tr[@data-file-manager-tree-node-type="file"][.//*[contains(text(), "houses")]]');
         $I->clickWithLeftButton('//tr[@data-file-manager-tree-node-type="file"][.//*[contains(text(), "houses")]]');
         $I->waitForText('Add');
         $I->click('Add');
         $I->waitForText('The block has been added successfully.');
         */
    }

    public function enterPageDetails(AcceptanceTester $I)
    {
        $I->clickWithLeftButton('//li[@data-guide-toolbar-action="page-settings"]');
        $I->waitForText('Composer');
        $I->fillField('input[id="ptComposer[1][name]"][name="ptComposer[1][name]"]', 'My Auto Page');
        $I->fillField('textarea[id="ptComposer[2][description]"]', 'This is my description of this automatic page.');
        $I->see('URL Slug');
        $I->fillField('//input[contains(@id, "url_slug")]', 'test-page');
        // Override for viewing manually as bottom navbar gets in way sometimes
        $I->executeJS("var objDiv = document.getElementById('ccm-panel-detail-page-composer');
objDiv.scrollTop = objDiv.scrollHeight;");
        $I->clickWithLeftButton('//div[@class="ccm-item-selector"]//a[@data-page-selector-link="choose"]');
        $I->waitForText('Full Sitemap', 20);
        $I->clickWithLeftButton('//span[@class="fancytree-title"][contains(text(),"Home")]');
    }

    public function publishAndVist(AcceptanceTester $I)
    {
        $I->waitForText('Publish Page');
        $I->click('Publish Page');
        $I->waitForText('XYZ TESTING');
        $I->logout();
        $I->amOnPage('/index.php/test-page');
        $I->waitForText('XYZ TESTING');
    }
}
