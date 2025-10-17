<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace text_editor\acceptance;

use text_editor\AcceptanceTester;

class TextEditorCest
{
    public function testTextEditor(AcceptanceTester $I)
    {
        $I->amAdmin();

        $I->amOnPage('/text-editor/config');
        $I->waitForText('Text editor');
        $I->click('#configform-allownewfiles');
        $I->click('Save');
        $I->seeSuccess();

        $I->amOnSpace1();
        $I->click('#contentForm_message');
        $I->click('.contentForm_options .btn-group .dropdown-toggle');
        $I->waitForText('Create file (Text, Log, XML)');
        $I->click('Create file (Text, Log, XML)', '.contentForm_options');
        $I->waitForText('Create file');
        $I->fillField('#createfile-filename', 'Test file name.tst');
        $I->click('Save');

        $I->waitForText('Edit file: Test file name.tst');
        $I->executeJS('document.querySelectorAll("div.CodeMirror")[0].CodeMirror.setValue("Test\r\nLine 2")');
        $I->click('Save');
        $I->seeSuccess();
        $I->fillField('#contentFormBody .humhub-ui-richtext[contenteditable]', 'Post with test text file.');
        $I->click('Submit');

        $I->waitForText('Post with test text file.', 10, '.wall-entry');
        $I->see('Test file name.tst - 12 B', '.wall-entry .file-preview-content');
        $I->click('Test file name.tst');
        $I->waitForText('Open file');
        $I->click('View');
        $I->waitForText('View file: Test file name.tst');
        $I->see("Test\r\nLine 2");
        $I->click('Close');

        $I->click('Test file name.tst');
        $I->waitForText('Open file');
        $I->click('Edit with Text editor');
        $I->waitForText('Edit file: Test file name.tst');
        $I->executeJS('document.querySelectorAll("div.CodeMirror")[0].CodeMirror.setValue("1st Line\r\nSecond Line")');
        $I->click('Save');
        $I->seeSuccess();
        $I->click('Test file name.tst');
        $I->waitForText('Open file');
        $I->click('View');
        $I->waitForText('View file: Test file name.tst');
        $I->see("1st Line\r\nSecond Line");
    }
}
