<?php


namespace Codeception\Module\Locators\Concrete5\Version8;


use Codeception\Module\Locators\Concrete5\BaseDashboardLocators;

class DashboardLocators extends BaseDashboardLocators
{
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'dashboard';
    }

    protected $packageInstallLink = ['xpath'=>"//div[@class='media-row']/div[@class='media-body']/h4[contains(text(), 'package_name')]/preceding-sibling::a[contains(@href,'install_package')]"];
    protected $packageInstallLinkWithHandle = ['xpath' => "//div[@id='ccm-dashboard-content-inner']/div[@class='media-row']/div[@class='media-body']/a[contains(@href,'install_package/package_handle')]"];
    protected $resultAlertInfo = ['xpath'=>"//div[@id='ccm-dashboard-result-message']/div[@class='alert alert-info']"];
    protected $packageDetailsLink = ['xpath'=>"//div[@class='media-row']/div[@class='media-body']/h4[contains(text(), 'package_name')]/preceding-sibling::a[contains(@href,'install/inspect_package')]"];
    protected $packageDescriptionBox = ['xpath'=>"//div[@id='ccm-dashboard-content-inner']/table/tbody/tr/td[contains(@class, 'ccm-addon-list-description')]/h3[contains(text(),'package_name')]"];
    protected $packageDetailsSinglePages = ['xpath'=>"//div[@id='ccm-dashboard-content-inner']/legend[contains(text(),'Single Pages')]/following-sibling::ul[1]/li"];
    protected $packageDetailsBlockTypes = ['xpath'=>"//div[@id='ccm-dashboard-content-inner']/legend[contains(text(),'Block Types')]/following-sibling::ul[1]/li"];
    protected $packageDetailsJobs = ['xpath'=>"//div[@id='ccm-dashboard-content-inner']/legend[contains(text(),'Jobs')]/following-sibling::ul[1]/li"];
    protected $packageUninstallAlert = ['xpath'=>"//div[@id='ccm-dashboard-content-inner']/form[@id='ccm-uninstall-form']//div[@class='alert alert-danger']"];
    protected $dashboardFormLink = ['xpath'=>"//div[@class='ccm-dashboard-form-actions-wrapper']/div[@class='ccm-dashboard-form-actions']/a[contains(text(),'button_text')]"];
    protected $dashboardFormButton = ['xpath'=>"//div[@class='ccm-dashboard-form-actions-wrapper']/div[@class='ccm-dashboard-form-actions']/input[@value='button_text']"];
    protected $dashboardPrivacyDialog = ['xpath'=>'//button[@data-action="agree-privacy-policy"]'];

}