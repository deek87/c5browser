<?php

namespace Codeception\Module\Traits;

/**
 * Trait HelperTrait.
 *
 * Trait containing all helper functions like type/getCookieObjectEtc
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
    public function type($keys = '')
    {
        $this->webDriver->getKeyboard()->sendKeys($keys);
    }

    public function pressEnter()
    {
        $this->webDriver->getKeyboard()->pressKey("\xEE\x80\x87");
    }

    /**
     * @param null $name
     *
     * @throws \Codeception\Exception\ModuleException
     *
     * @return Cookie[] | null
     */
    public function grabCookieObject($name = null)
    {
        if (empty($name)) {
            return $this->webDriver->manage()->getCookies();
        }
        $params['name'] = $name;
        $cookies = $this->filterCookies($this->webDriver->manage()->getCookies(), $params);
        if (empty($cookies)) {
            return null;
        }

        return $cookies;
    }

    public function setCookieObject(Cookie $cookie)
    {
        if (empty($cookie->getExpiry())) {
            $cookie->setExpiry((time() + 160000));
        }
        $this->webDriver->manage()->addCookie($cookie);
    }

    public function clearCookies()
    {
        $this->webDriver->manage()->deleteAllCookies();
    }
}
