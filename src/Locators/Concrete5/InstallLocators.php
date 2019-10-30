<?php


namespace Codeception\Module\Locators\Concrete5;


class InstallLocators
{

    public $installLocaleSelector = ['id'=>'wantedLocale'];
    public $installLocaleButton = ['xpath'=>"//form[@id='ccm-install-language-form']/div[@class='input-btn']/button"];
    public $requiredItems = 'i.fa-check';
    public $continueInstallationButton = ['xpath'=>"//form[@id='continue-to-installation']/a[contains(@class,'btn-primary')]"];
    public $installButton = ['xpath'=>"//div[@class='ccm-install-actions'/button"];
    public $installRedirect = 'index.php/install';
    public $siteName = ['id'=>'SITE'];
    public $startingPointEmpty = ['id'=>'SAMPLE_CONTENT1'];
    public $startingPointFull = ['id'=>'SAMPLE_CONTENT2'];
    public $databaseServerField = ['id'=>'DB_SERVER'];
    public $databaseUserField = ['id'=>'DB_USERNAME'];
    public $databasePasswordField = ['id'=>'DB_PASSWORD'];
    public $databaseNameField = ['id'=>'DB_DATABASE'];
    public $privacyCheckbox = ['id'=>'privacy'];
    public $advancedSettings = ['xpath'=>"//div[@id='headingThree']/h4/a"];
    public $installLocaleCountry = ['id'=>'siteLocaleCountry'];
    public $installLocaleLang = ['id'=>'siteLocaleLanguage'];
    public $installTimezone = ['id'=>'SERVER_TIMEZONE'];
    public $ignoreWarningsCheckbox = ['id'=>'ignore-warnings'];



}