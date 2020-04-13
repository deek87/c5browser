<?php

namespace Codeception\Module\Locators\Concrete5\Version9;

use Codeception\Module\Locators\Concrete5\BaseInstallLocators;

class InstallLocators extends BaseInstallLocators
{
    protected $installLocaleSelector = ['id' => 'wantedLocale'];
    protected $installLocaleButton = ['xpath' => "//form[@id='ccm-install-language-form']//div[contains(@class,'input-group')]/button"];
    protected $requiredItems = 'i.fa-check';
    protected $continueInstallationButton = ['xpath' => "//form[@id='continue-to-installation']/a[contains(@class,'btn-primary')]"];
    protected $installButton = ['xpath' => "//div[@class='ccm-install-actions'/button"];
    protected $installRedirect = 'index.php/install';
    protected $siteName = ['id' => 'SITE'];
    protected $startingPointEmpty = ['id' => 'SAMPLE_CONTENT1'];
    protected $startingPointFull = ['id' => 'SAMPLE_CONTENT2'];
    protected $databaseServerField = ['id' => 'DB_SERVER'];
    protected $databaseUserField = ['id' => 'DB_USERNAME'];
    protected $databasePasswordField = ['id' => 'DB_PASSWORD'];
    protected $databaseNameField = ['id' => 'DB_DATABASE'];
    protected $privacyCheckbox = ['xpath' => "//form//input[@name='privacy']"];
    protected $advancedSettings = ['xpath' => "//div[@id='headingThree']/h4/a"];
    protected $installLocaleCountry = ['id' => 'siteLocaleCountry'];
    protected $installLocaleLang = ['id' => 'siteLocaleLanguage'];
    protected $installTimezone = ['id' => 'SERVER_TIMEZONE'];
    protected $ignoreWarningsCheckbox = ['id' => 'ignore-warnings'];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'install';
    }
}
