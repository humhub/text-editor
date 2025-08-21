<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace text_editor;

use humhub\modules\text_editor\models\CreateFile;
use humhub\modules\text_editor\models\forms\ConfigForm;
use humhub\modules\text_editor\Module;
use Yii;

class TextEditorTest extends UnitTester
{
    public function testTextEditor()
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('text-editor');

        $this->assertFalse($module->canCreate());

        $config = new ConfigForm();
        $config->allowNewFiles = true;
        $config->save();

        $this->assertTrue($module->canCreate());

        $createFile = new CreateFile();
        $createFile->fileName = 'test.any';
        $testFile = $createFile->save();

        $this->assertEquals('text/plain', $testFile->mime_type);
        $this->assertTrue($module->isSupportedType($testFile));
        $this->assertTrue($module->canView($testFile));
        $this->assertTrue($module->canEdit($testFile));

        $testFile->mime_type = 'image/jpeg';

        $this->assertFalse($module->isSupportedType($testFile));
        $this->assertFalse($module->canView($testFile));
        $this->assertFalse($module->canEdit($testFile));
    }
}
