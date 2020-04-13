<?php

namespace Codeception\Module\Locators;

/**
 * Interface LocatorInterface.
 */
interface LocatorInterface
{
    /**
     * Returns a string locating an element in concrete5.
     *
     * @param $locator string
     * @param $replace array| null
     *
     * @return null|string
     */
    public function get($locator, $replace);

    /**
     * Checks if this locator element exists on this locator.
     *
     * @param $locator string
     *
     * @return null|string
     */
    public function has($locator);

    /**
     * Returns the name of this locator.
     *
     * @return string
     */
    public function getName();
}
