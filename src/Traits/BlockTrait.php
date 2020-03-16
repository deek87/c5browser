<?php


namespace Codeception\Module\Traits;


trait BlockTrait
{


    public function addBlockToPage($blockType, $area = 'Main')
    {
        /**
         * $I->comment("I'm Adding A Content Block To The Page");
        $I->clickWithLeftButton('//div[contains(@class,"ccm-area-drag-area")][text()="Empty Main Area"]');
        $I->waitForElementVisible('//div[@class="popover fade bottom"]//a[@data-menu-action="area-add-block"]');
        $I->clickWithLeftButton('//div[@class="popover fade bottom"][contains(@style,"display: block;")]//a[@data-menu-action="area-add-block"]');
        $I->waitForText('Blocks',20);
        $I->waitForElement('//a[@data-block-type-handle="content"]');
        $I->clickWithLeftButton('//a[@data-block-type-handle="content"]');
        $I->waitForElement('div.cke_inner');
        $I->type('XYZ TESTING');
        $I->comment("I'm Adding Bold To The Next Entered Text");
        $I->canSeeElement('div.cke_inner');
        $I->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
        $I->wait(0.5);
        $I->clickWithLeftButton('//div[@contenteditable="true"][contains(@class,"cke_editable")]');
        $I->wait(0.5);
        $I->type(' EXTRA TEST');
        $I->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
        $I->wait(0.5);
        $I->clickWithLeftButton('//div[@class="cke_inner"]//span[@class="cke_button_label cke_button__save_label"]');
        $I->waitForText('The block has been added successfully.');
         */
        $this->comment("I'm Adding A " . $blockType . " Block To The " . $area . " Area of the current page.");
        $this->clickWithLeftButton($this->getPathFromLocator('areaZone', ['Main' => $area]));

        $this->waitForElementVisible('//div[@class="popover fade bottom"]//a[@data-menu-action="area-add-block"]');
        $this->clickWithLeftButton('//div[@class="popover fade bottom"][contains(@style,"display: block;")]//a[@data-menu-action="area-add-block"]');
        $this->waitForText('Blocks', 20);
        $this->waitForElement($this->getPathFromLocator('blockElement', ['content' => $blockType]));
        $this->clickWithLeftButton($this->getPathFromLocator('blockElement', ['content' => $blockType]));


    }

    public function saveChangesToBlock($blockType = null)
    {

        if ($blockType == 'content') {
            $this->comment('I click on save button in ckEditor');
            $this->clickWithLeftButton($this->getPathFromLocator('ckEditorSaveButton'));

        } else {
            $this->waitForElement($this->getPathFromLocator('uiDialogPrimaryButton'));
            $this->comment('I click on the primary button.');
            $this->click($this->getPathFromLocator('uiDialogPrimaryButton'));

        }
        $this->comment('I wait for the block to be added.');

        $this->waitForElement($this->getPathFromLocator('notificationSuccess'));

    }

    public function addContentBlock($content = 'Testing', $area = 'Main', $drag = false)
    {
        if ($drag === true) {
            $this->dragAndDropBlock('type', $area);
        } else {
            $this->addBlockToPage('type', $area);
        }
        $this->addTextToContentBlock($content, false);
        $this->addTextToContentBlock($content, true);
        $this->saveChangesToBlock($content);
    }

    public function addTextToContentBlock($text, $addBold = false)
    {
        $this->waitForElement('div.cke_inner');
        if (!$addBold) {
            $this->comment("I'm adding the text into the content block");
            $this->type($text);
            $this->pressEnter();

        } else {
            $this->comment("I'm adding the text into the content block with bold");
            $this->canSeeElement('div.cke_inner');
            $this->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
            $this->wait(0.5);
            $this->clickWithLeftButton('//div[@contenteditable="true"][contains(@class,"cke_editable")]');
            $this->wait(0.5);
            $this->type($text);
            $this->clickWithLeftButton('//div[@class="cke_inner"]//span[@role="presentation"]//span[contains(@class,"cke_button__bold_icon")]');
        }
        $this->wait(0.5);

    }

    /**
     * @param $blockname
     * @param $areaname
     * @throws \Exception
     */
    public function dragAndDropBlock($blockname, $areaname = 'Page Footer')
    {
        $this->debug('I look for the add button.');
        $this->clickWithLeftButton('.ccm-toolbar-add');
        $this->debug('I wait for the block list to load.');
        $this->waitForText($blockname);
        $this->debug('I drag the "' . $blockname . '" to the area named "' . $areaname . '"');
        $this->dragAndDrop('//a[@data-panel-add-block-drag-item="block"][@title="' . $blockname . '"]',
            $this->getPathFromLocator('areaZone', ['Main' => $areaname]));

    }


    public function dragAndDropImageBlock($imageFilename, $areaname = 'Main')
    {
        $this->dragAndDropBlock('image', $areaname);
        $this->debug('I wait for the add block popup.');
        $this->waitForElement('div.ccm-file-selector-choose-new');
        $this->debug('I select choose new file.');
        $this->clickWithLeftButton('div.ccm-file-selector-choose-new');
        $this->debug('I wait for the filemanager');
        $this->waitForElement('//div[contains(@class,"ccm-ui")][@data-header="file-manager"]');
        $this->debug('I wait for the look for the image named "' . $imageFilename . '".');
        $this->waitForElement('//tr[@data-file-manager-tree-node-type="file"][.//*[contains(text(), "' . $imageFilename . '")]]');
        $this->debug('I click on the image named "' . $imageFilename . '".');
        $this->clickWithLeftButton('//tr[@data-file-manager-tree-node-type="file"][.//*[contains(text(), "' . $imageFilename . '")]]');
        $this->saveChangesToBlock();
    }

}