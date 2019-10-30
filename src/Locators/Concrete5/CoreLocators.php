<?php


namespace Codeception\Module\Locators\Concrete5;



class CoreLocators
{

    public $usernameField = ['id'=>'uName'];
    public $passwordField = ['id'=>'uPassword'];
    public $passwordConfirmField = ['id'=>'uPasswordConfirm'];
    public $emailField = ['id'=>'uEmail'];
    public $toolbar = ['id'=>'ccm-toolbar'];
    public $primaryButton = 'btn .btn-primary';
    public $systemAlertBox = ['xpath'=>"//div[contains(@class,'ccm-system-errors alert')"];
    public $dismissSystemAlertBox = ['xpath'=>"//div[contains(@class,'ccm-system-errors alert')/button"];
    public $loginPage = '/index.php/login';
    public $loginButton = ['xpath'=>"//div[contains(@class,'authentication-type')/form//button"];


}