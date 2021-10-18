<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\models;

use humhub\modules\text_editor\Module;
use humhub\modules\file\models\File;
use Yii;
use yii\base\Model;

/**
 * CreateFile is a form for create a new text file
 *
 * @author Luke
 */
class CreateFile extends Model
{
    /**
     * @var string
     */
    public $fileName;

    /**
     * @var bool
     */
    public $openEditForm = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fileName', 'required'],
            ['fileName', 'validateFileName'],
            ['openEditForm', 'boolean'],
        ];
    }

    public function validateFileName($attribute)
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('text-editor');

        if (!$module->isSupportedType($this->fileName)) {
            $this->addError($attribute, Yii::t('TextEditorModule.base', 'Not allowed file type!'));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'openEditForm' => Yii::t('TextEditorModule.base', 'Edit the new file in the next step')
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('text-editor');
        $allowedExtensions = '<code>' . implode('</code>, <code>', array_keys($module->extensions)) . '</code>';

        return [
            'fileName' => Yii::t('TextEditorModule.base', 'Allowed extensions: {extensions}', ['extensions' => $allowedExtensions])
        ];
    }

    /**
     * @return false|File
     */
    public function save()
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('text-editor');

        if (!$this->validate()) {
            return false;
        }

        $file = new File();
        $file->file_name = $this->fileName;
        $file->size = 0;
        $file->mime_type = $module->getMimeType($this->fileName);
        if (!$file->save()) {
            return false;
        }

        $file->store->setContent('');

        return $file;
    }

}
