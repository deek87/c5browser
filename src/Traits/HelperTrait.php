<?php


namespace Codeception\Module\Traits;


use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverKeys;

/**
 * Trait HelperTrait
 *
 * Trait containing all helper functions like type/getCookieObjectEtc
 * @package Codeception\Module\Traits
 */
trait HelperTrait
{

    /**
     * @var string
     */
    public static $currentUrl;

    /**
     * @param $url
     */
    public function setCurrentUrl($url)
    {
        self::$currentUrl = $url;
    }


    /**
     * @param string $keys
     */
    public function type($keys = "")
    {
        $this->webDriver->getKeyboard()->sendKeys($keys);

    }

    public function pressEnter()
    {
        $this->webDriver->getKeyboard()->pressKey("\xEE\x80\x87");
    }

    /**
     * @param null $name
     * @return Cookie[] | null
     * @throws \Codeception\Exception\ModuleException
     */
    public function grabCookieObject($name = null)
    {
        if (empty($name)) {
            return $this->webDriver->manage()->getCookies();
        } else {
            $params['name'] = $name;
            $cookies = $this->filterCookies($this->webDriver->manage()->getCookies(), $params);
            if (empty($cookies)) {
                return null;
            }
            return $cookies;
        }


    }

    /**
     * @param Cookie $cookie
     */
    public function setCookieObject(Cookie $cookie)
    {
        if (empty($cookie->getExpiry())) {
            $cookie->setExpiry((time() + 160000));
        }
        $this->webDriver->manage()->addCookie($cookie);
    }

    /**
     *
     */
    public function clearCookies() {
        $this->webDriver->manage()->deleteAllCookies();
    }

}