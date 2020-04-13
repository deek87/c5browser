<?php

namespace Codeception\Module\Traits;

trait FileManagerTrait
{
    public function searchAndSelectFile($filename)
    {
        $this->searchForFile($filename);
        $this->wait(2);
        $this->selectFromFileManager($filename);
    }

    public function selectFromFileManager($fileName)
    {
        $this->debug('I see the file named : '.$fileName.' and click on it.');
        $this->seeElement($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
        $this->clickWithLeftButton($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
    }

    public function rightClickFileInFileManager($fileName, $rightClickOption)
    {
        $this->debug('I see the file named : '.$fileName.' and click on it.');
        $this->seeElement($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
        $this->clickWithRightButton($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
    }

    public function sortBy($field, $order = 'asc')
    {
    }

    public function searchForFile($fileName)
    {
        $this->debug('I wait for the search input.');
        $this->waitForElement($this->getPathFromLocator('fileManagerSearch'));
        $this->clickWithLeftButton($this->getPathFromLocator('fileManagerSearch'));
        $this->type($fileName);
        $this->debug('I enter the filename :'.$fileName.' and press enter.');
        $this->pressEnter();
        $this->debug('I wait to see the file.');
        $this->debug($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
        $this->waitForElementVisible($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]), 30);
        $this->seeElement($this->getPathFromLocator('searchResultName', ['resultName' => $fileName]));
    }
}
