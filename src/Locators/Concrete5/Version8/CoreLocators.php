<?php

namespace Codeception\Module\Locators\Concrete5\Version8;

use Codeception\Module\Locators\Concrete5\BaseCoreLocators;

class CoreLocators extends BaseCoreLocators
{
    protected $usernameField = ['id' => 'uName'];
    protected $passwordField = ['id' => 'uPassword'];
    protected $passwordConfirmField = ['id' => 'uPasswordConfirm'];
    protected $areaZone = ['xpath' => '//div[@data-area-handle="Main"]//div[@class="ccm-area-drag-area"][last()]'];
    protected $areaZoneColumn = ['xpath' => '//div[@data-area-handle="Main"]//div[@data-area-display-name="Column 1"]//div[@class="ccm-area-drag-area"][last()]'];
    protected $blockElement = ['xpath' => '//a[@data-block-type-handle="content"]'];
    protected $emailField = ['id' => 'uEmail'];
    protected $toolbar = ['id' => 'ccm-toolbar'];
    protected $toolbarAddBlock = ['xpath' => '//div[@id="ccm-toolbar"]/ul/li[@data-guide-toolbar-action="add-content"]/a[@data-launch-panel="add-block"]'];
    protected $toolbarPageSettings = ['xpath' => '//div[@id="ccm-toolbar"]/ul/li[@data-guide-toolbar-action="page-settings"]/a[@data-launch-panel="page"]'];
    protected $toolbarEdit = ['xpath' => '//div[@id="ccm-toolbar"]/ul/li[@data-guide-toolbar-action="check-in"]/a[@data-toolbar-action="check-in"]'];
    protected $launchPanel = ['xpath' => '//a[@data-launch-panel="panel"]'];
    protected $primaryButton = ['xpath' => "//button[contains(@class, 'btn-primary')]"];
    protected $systemAlertBox = ['xpath' => "//div[contains(@class,'ccm-system-errors alert')]"];
    protected $dismissSystemAlertBox = ['xpath' => "//div[contains(@class,'ccm-system-errors alert')]/button"];
    protected $loginPage = '/index.php/login';
    protected $loginButton = ['xpath' => "//div[contains(@class,'authentication-type')]/form//button"];
    protected $editModeActive = ['xpath' => '//div[@id="ccm-toolbar"]//li[contains(@class, \'ccm-toolbar-page-edit-mode-active\')]'];
    protected $ckEditorSaveButton = ['xpath' => '//div[@class="cke_inner"]//span[@role="presentation"]/a[contains(@class,"cke_button__save")]/span[@class="cke_button_label cke_button__save_label"]'];
    protected $uiDialogBox = ['xpath' => '//div[@role="dialog"][contains(@class, "ui-dialog")]'];
    protected $uiDialogClose = ['xpath' => '//div[@role="dialog"][contains(@class, "ui-dialog")]//button[contains(@class, "ui-dialog-titlebar-close")]'];
    protected $uiDialogPrimaryButton = ['xpath' => '//div[@class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"]/div/a[contains(@class, "btn-primary")]'];
    protected $uiDialogCancelButton = ['xpath' => '//div[@class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"]/div/a[contains(@class, "btn-default")]'];
    protected $notificationSuccess = ['xpath' => "//div[contains(@class, 'ui-pnotify')]/div[contains(@class, 'ccm-notification-success')]"];
    protected $ajaxSearchResults = ['xpath' => '//div[@data-search-element="results"]'];
    protected $fileManagerSearch = ['xpath' => "//div[contains(@class, 'ccm-header-search-form')]/form/div[@class='ccm-header-search-form-input']/input[@name='fKeywords']"];
    protected $searchResultName = ['xpath' => "//div[@data-search-element='results']//table[contains(@class,'ccm-search-results-table')]/tbody/tr/td[@class='ccm-search-results-name'][contains(text(),'resultName')]/parent::tr"];
    protected $fileSelectorButton = ['xpath' => '//div[@data-file-selector="ccm-b-image"]/div[@class="ccm-file-selector-choose-new"]'];
    protected $fileSelectorButtonWithText = ['xpath' => '//div[@data-file-selector="ccm-b-image"]/div[@class="ccm-file-selector-choose-new"][contains(text(),"Choose Image")]'];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'core';
    }
}
