<?php

namespace Codeception\Module\Traits;

trait BlockTrait
{
    public function addBlockToPage($blockType, $area = 'Main')
    {
        $this->debug("I'm Adding A ".$blockType.' Block To The '.$area.' Area of the current page.');
        $this->clickWithLeftButton($this->getPathFromLocator('areaZone', ['Main' => $area]));

        $this->waitForElementVisible('//div[@class="popover fade bottom"]//a[@data-menu-action="area-add-block"]');
        $this->clickWithLeftButton('//div[@class="popover fade bottom"][contains(@style,"display: block;")]//a[@data-menu-action="area-add-block"]');
        $this->waitForText('Blocks', 20);
        $this->waitForElement($this->getPathFromLocator('blockElement', ['content' => $blockType]));
        $this->scrollTo($this->getPathFromLocator('blockElement', ['content' => $blockType]));
        $this->clickWithLeftButton($this->getPathFromLocator('blockElement', ['content' => $blockType]));
    }

    public function saveChangesToBlock($blockType = null)
    {
        if ($blockType == 'content') {
            $this->debug('I click on save button in ckEditor');
            $this->clickWithLeftButton($this->getPathFromLocator('ckEditorSaveButton'));
        } else {
            $this->waitForElement($this->getPathFromLocator('uiDialogPrimaryButton'));
            $this->debug('I click on the primary button.');
            $this->clickWithLeftButton($this->getPathFromLocator('uiDialogPrimaryButton'));
        }
        $this->debug('I wait for the block to be added.');

        $this->waitForElement($this->getPathFromLocator('notificationSuccess'));
    }

    public function addContentBlock($content = 'Testing', $area = 'Main', $drag = false)
    {
        if ($drag === true) {
            $this->dragAndDropBlock('content', $area);
        } else {
            $this->addBlockToPage('content', $area);
        }
        $this->addTextToContentBlock($content, false);
        $this->addTextToContentBlock($content, true);
        $this->saveChangesToBlock('content');
    }

    public function addTextToContentBlock($text, $addBold = false)
    {
        $this->waitForElement('div.cke_inner');
        if (!$addBold) {
            $this->debug("I'm adding the text into the content block");
            $this->type($text);
            $this->pressEnter();
        } else {
            $this->debug("I'm adding the text into the content block with bold");
            $this->clickWithLeftButton('//div[@contenteditable="true"][contains(@class,"cke_editable")]');
            $this->wait(0.5);
            $this->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
            $this->wait(0.5);
            $this->type($text);
            $this->pressEnter();
            $this->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
        }
        $this->wait(0.5);
    }

    /**
     * @param $blockname
     * @param $areaname
     * @param mixed $blockType
     *
     * @throws \Exception
     */
    public function dragAndDropBlock($blockType, $areaname = 'Page Footer')
    {
        $this->debug('I look for the add button.');
        $this->clickWithLeftButton($this->getPathFromLocator('toolbarAddBlock'));
        $this->debug('I wait for the block list to load.');
        $this->waitForElement($this->getPathFromLocator('blockElement', ['content' => $blockType]));
        $this->scrollTo($this->getPathFromLocator('blockElement', ['content' => $blockType]));
        $this->wait(0.5);
        $this->debug('I drag the "'.$blockType.'" type to the area named "'.$areaname.'"');
        $this->dragAndDrop(
            $this->getPathFromLocator('blockElement', ['content' => $blockType]),
            $this->getPathFromLocator('areaZone', ['Main' => $areaname])
        );
        $this->wait(1);
    }

    public function dragAndDropImageBlock($imageFilename, $areaname = 'Main', $hoverImage = null)
    {
        $this->dragAndDropBlock('image', $areaname);
        $this->debug('I wait for the add block popup.');
        $this->waitForElement($this->getPathFromLocator('fileSelectorButton'), 30);
        $this->debug('I select choose new file.');
        $this->clickWithLeftButton($this->getPathFromLocator('fileSelectorButton'));
        $this->debug('I wait for the filemanager');
        $this->waitForElement('//div[contains(@class,"ccm-ui")][@data-header="file-manager"]');
        $this->debug('I wait for the look for the image named "'.$imageFilename.'".');
        $this->searchAndSelectFile($imageFilename);

        if (!empty($hoverImage)) {
            $this->waitForElement($this->getPathFromLocator('fileSelectorButtonWithText', ['Choose Image' => 'Choose Image On-State']), 30);
            $this->clickWithLeftButton($this->getPathFromLocator('fileSelectorButtonWithText', ['Choose Image' => 'Choose Image On-State']));
            $this->searchAndSelectFile($hoverImage);
        }
        $this->saveChangesToBlock();
    }
}
