<?php

namespace Codeception\Module;


use Codeception\Lib\ModuleContainer;
use Codeception\Module\Locators\LocatorInterface;
use Codeception\Exception\ModuleException;
use Codeception\Module\Traits\BlockTrait;
use Codeception\Module\Traits\FileManagerTrait;
use Codeception\Module\Traits\HelperTrait;
use Codeception\Module\Traits\PackageTrait;
use Facebook\WebDriver\Interactions\Internal\WebDriverButtonReleaseAction;
use Facebook\WebDriver\Interactions\Internal\WebDriverClickAndHoldAction;
use Facebook\WebDriver\Interactions\Internal\WebDriverMouseMoveAction;
use Facebook\WebDriver\Interactions\WebDriverActions;
use PHPUnit\Exception;

/**
 * Class Concrete5Browser
 * @package Codeception\Module
 * @author Derek Cameron <info@derekcameron.com>
 */
class Concrete5Browser extends WebDriver {

    use BlockTrait;
    use HelperTrait;
    use PackageTrait;
    use FileManagerTrait;
    /** @var LocatorInterface[] */
    protected $locators = [];

    /**  @var int Represents the major version of concrete5 */
    protected $version = 8;
    /** @var array Array of the required fields for this driver */
    protected $requiredFields = [
        'url',
        'browser',
        'username',
        'password',
        'database host',
        'database user',
        'database password',
        'database name',
        'admin email',
    ];



    /**
     * Module constructor.
     *
     * Requires module container (to provide access between modules of suite) and config.
     *
     * @param ModuleContainer $moduleContainer
     * @param array|null $config
     */
    public function __construct(ModuleContainer $moduleContainer, $config = null)
    {
        parent::__construct($moduleContainer, $config);
        if (isset($this->config['c5_version']) && version_compare($this->config['c5_version'] , '5.7.5.13') < 1) {
            $this->version = 7;
        } elseif (isset($this->config['c5_version']) && version_compare($this->config['c5_version'] , '9.0.0') >= 0) {
            $this->version = 9;
        }
        // Instantiate the locator
        $this->initiateLocators();
    }

    /**
     *
     */
    protected function initiateLocators() {

        if (!empty($this->config['locators'])) {
            if (is_array($this->config['locators'])) {
                foreach ($this->config['locators'] as $key=>$locator) {
                    $this->locators[$key] = new $locator;
                }
            } else {
                $locator = $this->config['locators'];
                $this->locators['custom'] = new $locator;
            }
        }

        $core = 'Codeception\Module\Locators\Concrete5\Version'.$this->version.'\CoreLocators';
        $this->locators['core'] = new $core();
        $dashboard = 'Codeception\Module\Locators\Concrete5\Version'.$this->version.'\DashboardLocators';
        $this->locators['dashboard'] = new $dashboard();
    }

    /**
     * @param string $path
     * @param array | null $replace
     * @return bool|string|null
     */
    public function getPathFromLocator($path, $replace=null) {
        foreach ($this->locators as $locator) {
            if ($locator->has($path)) {
                return $locator->get($path, $replace);
            }
        }

        return false;
    }

    /**
     * @param $locator string | LocatorInterface
     * @param null $name
     * @throws ModuleException
     */
    protected function _addLocator($locator, $name=null)
    {
        if (is_object($locator)) {
            if (!($locator instanceof LocatorInterface)) {
                throw new ModuleException($this,get_class($locator).' must implement Codeception\Module\Locators\LocatorInterface');
            }

        } elseif (is_string($locator)) {
            $locator = new $locator;
             if ($locator instanceof LocatorInterface) {
                $this->locators[$name] = $locator;
            } else {
                throw new ModuleException($this,get_class($locator).' must implement Codeception\Module\Locators\LocatorInterface');
            }
        } else {
            throw new ModuleException($this,'$locator must be a string or implement Codeception\Module\Locators\LocatorInterface.');
        }

        if ($name === null) $name =$locator->getName();
        $this->locators[$name] = $locator;

    }

    /**
     * @param $name
     */
    protected function _removeLocator($name) {


        if (is_string($name) && isset($this->locators[$name])) {
            unset($this->locators[$name]);
        } else {
            if (is_object($name)) {
                $className = get_class($name);
            } else {
                $className = '';
            }

            foreach ($this->locators as $key=>$locator) {
                if ($key == $className || get_class($locator) == $name || $name == $locator) {
                    unset($this->locators[$key]);
                    break;
                }
                if (is_object($name) && get_class($locator) == get_class($name)) {
                    unset($this->locators[$key]);
                    break;
                }
            }
        }
    }

    /**
     * @param string| null $dbName
     * @param string| null $dbUser
     * @param string| null $dbPass
     * @param string $langCode
     * @param string $localeCode
     * @param bool $fullContent
     * @throws Exception
     * @throws ModuleException
     * @throws \Exception
     */
    public function installConcrete5($dbName = null, $dbUser = null, $dbPass = null, $langCode='en', $localeCode='US', $fullContent = true) {

        $install = 'Codeception\Module\Locators\Concrete5\Version'.$this->version.'\InstallLocators';
        $this->_addLocator($install, 'install');
        $this->debug('I visit the concrete5 install page.');
        $this->amOnPage($this->getPathFromLocator('installRedirect'));
        if ($this->_findElements($this->getPathFromLocator('installLocaleSelector'))) {
            $this->debug('I select ' . $langCode . '_' . $localeCode . ' as the installation language.');
            $this->selectOption($this->getPathFromLocator('installLocaleSelector'), strtolower($langCode) .
                '_' . strtoupper($localeCode));
            $this->clickWithLeftButton($this->getPathFromLocator('installLocaleButton'));

        }
        $this->debug('I check the required items.');
        $this->waitForText("Required Items", 30);
        $this->seeNumberOfElements($this->getPathFromLocator('requiredItems'),[16,18]);
        $this->debug('I continue with installation.');
        $this->clickWithLeftButton($this->getPathFromLocator('continueInstallationButton'));
        $this->debug('I fill in incorrect details for the site.');
        $this->waitForElement($this->getPathFromLocator('siteName'));
        $this->fillField($this->getPathFromLocator('siteName'),'concrete5');
        $this->fillField($this->getPathFromLocator('emailField'),'test@concrete5-test.test');
        $this->fillField($this->getPathFromLocator('passwordField'),'RandomPassword1');
        $this->fillField($this->getPathFromLocator('passwordConfirmField'),'RandomPassword2');
        $this->fillField($this->getPathFromLocator('databaseServerField'),'unkownhost');
        $this->fillField($this->getPathFromLocator('databaseUserField'),'invalid_user');
        $this->fillField($this->getPathFromLocator('databasePasswordField'),'invalid_user');
        $this->fillField($this->getPathFromLocator('databaseNameField'),'concrete5_tests');
        $this->scrollTo($this->getPathFromLocator('privacyCheckbox'));
        $this->debug('I check privacy checkbox');
        $this->checkOption($this->getPathFromLocator('privacyCheckbox'));
        $this->seeCheckboxIsChecked($this->getPathFromLocator('privacyCheckbox'));
        $this->debug('I select empty site content.');
        $this->checkOption($this->getPathFromLocator('startingPointEmpty'));
        $this->clickWithLeftButton($this->getPathFromLocator('primaryButton'));
        $this->debug('I wait for error to be displayed.');
        $this->waitForElement($this->getPathFromLocator('systemAlertBox'),20);
        $this->debug('I fill in the correct details for the site.');
        $this->debug('I enter the site name');
        $this->fillField($this->getPathFromLocator('siteName'),isset($this->config['site'])? $this->config['site'] :'concrete5');
        $this->debug('I enter the admin email.');
        $this->fillField($this->getPathFromLocator('emailField'),$this->config['admin email']);
        $this->debug('I enter the admin password.');
        $this->fillField($this->getPathFromLocator('passwordField'), $this->config['password']);
        $this->debug('I confirm the admin password.');
        $this->fillField($this->getPathFromLocator('passwordConfirmField'),$this->config['password']);

        $this->debug('I enter the database host.');
        if (empty($this->config['database host'])) {
            $this->fillField($this->getPathFromLocator('databaseServerField'),'localhost');
        } else {
            $this->fillField($this->getPathFromLocator('databaseServerField'), $this->config['database host']);
        }
        if (empty($dbName)) {
            $dbName = $this->config['database name']?: 'concrete5_tests';
        }
        if (empty($dbPass)) {
            $dbPass = $this->config['database password']?: '';
        }
        if (empty($dbUser)) {
            $dbUser = $this->config['database user']?: '';
        }
        $this->debug('I enter the database name.');
        $this->fillField($this->getPathFromLocator('databaseNameField'),$dbName);
        $this->debug('I enter the database user.');
        $this->fillField($this->getPathFromLocator('databaseUserField'),$dbUser);
        if (empty($dbPass)) {
            $this->clearField($this->getPathFromLocator('databasePasswordField'));
        } else {
            $this->debug('I enter the database password.');
            $this->fillField($this->getPathFromLocator('databasePasswordField'),$dbPass);
        }


        $this->debug('I select empty site content.');
        $this->checkOption($this->getPathFromLocator('startingPointEmpty'));
        $this->debug('I click Install concrete5.');
        $this->clickWithLeftButton('.btn-primary');
        if (!empty($this->matchVisible($this->getPathFromLocator('ignoreWarningsCheckbox')))) {
            $this->seeElement($this->getPathFromLocator('ignoreWarningsCheckbox'));
            $this->debug('I check ignore the warnings alert box.');
            $this->checkOption($this->getPathFromLocator('ignoreWarningsCheckbox'));
            $this->clickWithLeftButton($this->getPathFromLocator('primaryButton'));
        } else {
            $this->debug('I do not see any warnings.');
        }

        $this->debug('I wait for installation to finish.');
        $this->waitForText("Installation Complete",180);
        $this->saveSessionSnapshot('admin');
        $this->debug('Concrete5 installed.');

        $this->_removeLocator('install');

    }

    /**
     * @param null $username
     * @param null $password
     * @param bool $useSnapshot
     * @throws \Exception
     */
    public function login($username = null, $password=null, $useSnapshot = true)
	{
        if ($username === null)
        {
            $username = $this->config['username'];
        }
        if ($password === null)
        {
            $password = $this->config['password'];
        }


        if ($useSnapshot && $this->loadSessionSnapshot($username))
        {
            $this->debug('I am already logged in as this user.');
            return;
        }
        $this->debug('I open the Login Page');
        $this->amOnPage($this->getPathFromLocator('loginPage'));
        $this->debug('I fill the username field');
        $this->fillField($this->getPathFromLocator('usernameField'), $username);
        $this->debug('I fill the password field');
        $this->fillField($this->getPathFromLocator('passwordField'), $password);

        $this->debug('I click Login button');
        $this->click($this->getPathFromLocator('loginButton'));
        $this->waitForElementNotVisible($this->getPathFromLocator('loginButton'), isset($this->config['timeout'])? $this->config['timeout']:60);

        if ($this->version > 7 && !empty($this->_findElements($this->getPathFromLocator('dashboardPrivacyDialog')))) {
            $this->click($this->getPathFromLocator('dashboardPrivacyDialog'));
        }
        if ($useSnapshot)
        {
            $this->saveSessionSnapshot($username);
        }
    }



    public function loadNewPage($pageType = 'Page')
    {
        $this->seeElement($this->getPathFromLocator('launchPanel',['panel'=>'sitemap']));
        $this->clickWithLeftButton($this->getPathFromLocator('launchPanel',['panel'=>'sitemap']));
        $this->waitForText('New Page', '30');
        $this->click($pageType);
        $this->waitForElement($this->getPathFromLocator('editModeActive'));
        $this->waitForJS('return document.readyState == "complete"', 60);
        $this->waitForJS('return !!window . jQuery && window . jQuery . active == 0;', 60);
    }



    public function scheduleAJob($jobName, $everyX = '5', $period = 'minutes')
    {

        $this->amOnPage('/index.php/dashboard/system/optimization/jobs');
        $this->see('Index Search Engine - Updates');

        $this->click('Run');
        $this->click('View'); // Dashboard locator
        $this->fillField('isScheduled', '1');
        $this->see('0');
        $this->see('Run this Job Every');
        $this->selectOption('unit', 'minutes');
        $this->click('Save');
        $this->wait(10);
        $this->seeCurrentURLEquals('/index.php/dashboard/system/optimization/jobs/job_scheduled');
        $this->see('Job schedule updated successfully.');
    }

    public function checkCronStatus()
    {
        //$this->clic
    }
}