<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\models;

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
            ['fileName', 'filter', 'filter' => [$this, 'sanitizeFileName']],
            ['fileName', 'required'],
            ['fileName', 'string', 'max' => 255],
            ['openEditForm', 'boolean'],
        ];
    }

    /**
     * Replaces the characters that are not allowed in file names the same way as on a regular file upload
     *
     * @param mixed $value
     * @return string
     */
    public function sanitizeFileName($value)
    {
        if (!is_string($value)) {
            return '';
        }

        /* @var \humhub\modules\file\Module $fileModule */
        $fileModule = Yii::$app->getModule('file');
        $pattern = $fileModule->fileNameValidationPattern;

        if (!empty($pattern)) {
            $value = (string)preg_replace($pattern, '_', $value);
        }

        return trim($value);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'openEditForm' => Yii::t('TextEditorModule.base', 'Edit the new file in the next step'),
        ];
    }

    /**
     * @return false|File
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $file = new File();
        $file->file_name = $this->fileName;
        $file->size = 0;
        $file->mime_type = 'text/plain';
        if (!$file->save()) {
            return false;
        }

        $file->store->setContent('');

        return $file;
    }

}
