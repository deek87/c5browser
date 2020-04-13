<?php

namespace Concrete\Package\DkTestPackage\Block\DkTest;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    public function getBlockTypeName()
    {
        return t('Test Block');
    }

    public function getBlockTypeDescription()
    {
        return t('Test Block for testing');
    }

    public function view()
    {
        echo 'hello world';
    }
}
