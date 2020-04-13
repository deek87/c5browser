<?php

namespace Concrete\Package\DkTestPackage;

use Package;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends Package
{
    protected $pkgHandle = 'dk_test_package';
    protected $appVersionRequired = '5.7.5.13';
    protected $pkgVersion = '0.0.1';

    public function getPackageName()
    {
        return t('DK Test Package');
    }

    public function getPackageDescription()
    {
        return t('Package for testing installs');
    }

    public function install()
    {
        $pkg = parent::install();
        \BlockType::installBlockType('dk_test', $pkg);
        $this->install_pages(
            $pkg,
            '/dashboard/dk_test',
            ['cName' => t('DK TEST'), 'cDescription' => t('A Test Page')]
        );
    }

    private function install_pages($pkg, $page, $info)
    {
        // Check if the page exists
        $p = \SinglePage::add($page, $pkg);
        if (is_null($p)) {
            $p = \Page::getByPath($page);
            if (is_object($p) && !$p->isError()) {
                // Update the information if it does exist
                $p->update($info);
            }
        } else {
            $p->update($info);
        }
    }
}
