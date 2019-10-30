<?php

namespace Codeception\Module;


use Codeception\Lib\ModuleContainer;
use Codeception\Module\Locators\Concrete5\InstallLocators;

/**
 * Class Concrete5Browser
 * @package Codeception\Module
 * @author derekcameron
 */
class Concrete5Browser extends WebDriver {


    protected $locators = [];

    /**
     * @var array
     */
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
        'language',
        'locale'
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
        // Instantiate the locator
        $this->initiateLocators();
    }

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
        $this->locators['core'] = new Locators\Concrete5\CoreLocators();
        $this->locators['dashboard'] = new Locators\Concrete5\DashboardLocators();
    }

    public function getPathFromLocator($path) {
        foreach ($this->locators as $locator) {
            if (isset($locator->$path)) {
                return $locator->$path;
            }
        }

        return false;
    }

    protected function _addLocator($locator, $name=null)
    {
        if (is_object($locator)) {
            $this->locators[$name] = $locator;
        } else {
            $this->locators[$name] = new $locator;
        }

    }

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

    public function installConcrete5($dbName = null, $langCode='en', $localeCode='US', $fullContent = true) {
        $this->_addLocator(InstallLocators::class, 'install');
        $this->debug('I visit the concrete5 install page.');
        $this->amOnPage($this->getPathFromLocator('installPage'));

        $this->debug('I select ' . $langCode . '_' . $localeCode . ' as the installation language.');
        $this->selectOption($this->getPathFromLocator('installLocaleSelector'), strtolower($langCode) .
            '_' . strtoupper($localeCode));
        $this->clickWithLeftButton($this->getPathFromLocator('installLocaleButton'));
        $this->debug('I check the required items.');
        $this->waitForText("Required Items");
        $this->seeNumberOfElements($this->getPathFromLocator('requiredItems'),[16,18]);
        $this->debug('I continue with installation.');
        $this->clickWithLeftButton($this->getPathFromLocator('continueInstallationButton'));
        $this->debug('I fill in incorrect details for the site.');
        $this->fillField($this->getPathFromLocator('siteName'),'concrete5');
        $this->fillField($this->getPathFromLocator('emailField'),'test@concrete5-test.test');
        $this->fillField($this->getPathFromLocator('passwordField'),'RandomPassword1');
        $this->fillField($this->getPathFromLocator('passwordConfirmField'),'RandomPassword2');
        $this->fillField($this->getPathFromLocator('databaseServerField'),'unkownhost');
        $this->fillField($this->getPathFromLocator('databaseUserField'),'invalid_user');
        $this->fillField($this->getPathFromLocator('databasePasswordField'),'invalid_user');
        $this->fillField($this->getPathFromLocator('databaseNameField'),'concrete5_tests');
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
        $this->fillField($this->getPathFromLocator('siteName'),$this->config['site']?:'concrete5');
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
        $this->debug('I enter the database name.');
        $this->fillField($this->getPathFromLocator('databaseNameField'),$dbName);
        $this->debug('I enter the database user.');
        $this->fillField($this->getPathFromLocator('databaseUserField'),$this->config['database user']);
        if (empty($this->config['database password'])) {
            $this->clearField($this->getPathFromLocator('databasePasswordField'));
        } else {
            $this->debug('I enter the database password.');
            $this->fillField($this->getPathFromLocator('databasePasswordField'),$this->config['database password']);
        }


        $this->debug('I select empty site content.');
        $this->checkOption($this->getPathFromLocator('startingPointEmpty'));
        $this->debug('I click Install concrete5.');
        $this->clickWithLeftButton('.btn-primary');
        try {
            $this->debug('I check ignore the warnings alert box.');
            $this->seeElement($this->getPathFromLocator('ignoreWarningsCheckbox'));
            $this->checkOption($this->getPathFromLocator('ignoreWarningsCheckbox'));
            $this->clickWithLeftButton($this->getPathFromLocator('primaryButton'));
        } catch (\Exception $e) {
            //do nothing for now
        }

        $this->debug('I wait for installation to finish.');
        $this->waitForText("Installation Complete",180);
        $this->saveSessionSnapshot('admin');
        $this->debug('Concrete5 installed.');

        $this->_removeLocator('install');

    }

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
        $this->debug('I open the Login Page');
        $this->amOnPage($this->getPathFromLocator('loginPage'));
        if ($useSnapshot && $this->loadSessionSnapshot($username))
        {
            return;
        }
        $this->debug('I fill the username field');
        $this->fillField($this->getPathFromLocator('usernameField'), $username);
        $this->debug('I fill the password field');
        $this->fillField($this->getPathFromLocator('passwordField'), $password);

        $this->debug('I click Login button');
        $this->click($this->getPathFromLocator('loginButton'));
        $this->debug('I wait to see dashboard');
        $this->waitForText();
        if ($useSnapshot)
        {
            $this->saveSessionSnapshot($username);
        }
    }
}