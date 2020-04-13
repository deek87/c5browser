<?php

namespace Codeception\Module\Locators;

/**
 * Class AbstractLocator.
 *
 * @author Derek Cameron <info@derekcameron.com>
 */
abstract class AbstractLocator implements LocatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($locator, $replace = null)
    {
        if ($this->has($locator)) {
            $foundPath = $this->{$locator};
            if ($replace !== null && is_array($replace)) {
                foreach ($replace as $replacee => $replacer) {
                    if ($replacee !== $replacer) {
                        $foundPath = str_replace($replacee, $replacer, $foundPath);
                    }
                }
            }

            return $foundPath;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function has($locator)
    {
        return isset($this->{$locator});
    }
}
