<?php


namespace Codeception\Module\Locators\Concrete5\Version8;



use Codeception\Module\Locators\Concrete5\BaseCoreLocators;

class CoreLocators extends BaseCoreLocators
{

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'core';
    }

    protected $usernameField = ['id'=>'uName'];
    protected $passwordField = ['id'=>'uPassword'];
    protected $passwordConfirmField = ['id'=>'uPasswordConfirm'];
    protected $areaZone = ['xpath'=>'//div[@data-area-handle="Main"]//div[@class="ccm-area-drag-area"]'];
    protected $blockElement = ['xpath'=>'//a[@data-block-type-handle="content"]'];
    protected $emailField = ['id'=>'uEmail'];
    protected $toolbar = ['id'=>'ccm-toolbar'];
    protected $launchPanel = ['xpath'=>'//a[@data-launch-panel="panel"]'];
    protected $primaryButton = ['xpath'=>"//button[contains(@class, 'btn-primary')]"];
    protected $systemAlertBox = ['xpath'=>"//div[contains(@class,'ccm-system-errors alert')]"];
    protected $dismissSystemAlertBox = ['xpath'=>"//div[contains(@class,'ccm-system-errors alert')]/button"];
    protected $loginPage = '/index.php/login';
    protected $loginButton = ['xpath'=>"//div[contains(@class,'authentication-type')]/form//button"];
    protected $editModeActive = ['xpath'=> '//div[@id="ccm-toolbar"]//li[contains(@class, \'ccm-toolbar-page-edit-mode-active\')]'];
    protected $ckEditorSaveButton = ['xpath'=>'//div[@class="cke_inner"]//span[@class="cke_button_label cke_button__save_label"]'];
    protected $uiDialogPrimaryButton = ['xpath'=>'//div[@class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"]/div/a[contains(@class, "btn-primary")]'];
    protected $uiDialogCancelButton = ['xpath'=>'//div[@class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"]/div/a[contains(@class, "btn-default")]'];
    protected $notificationSuccess = ['xpath'=>"//div[contains(@class, 'ui-pnotify')]/div[contains(@class, 'ccm-notification-success')]"];



}