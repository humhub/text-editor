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
use yii\base\Exception;
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
    public $fileType;

    /**
     * @var string
     */
    public $fileName;

    /**
     * @var bool
     */
    public $openEditForm = true;

    public function init()
    {
        /* @var Module $module */
        $module = Yii::$app->getModule('text-editor');

        if (!$module->isSupportedType($this->fileType)) {
            throw new Exception('Invalid file type!');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fileName', 'required'],
            ['openEditForm', 'boolean'],
        ];
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
        $file->file_name = $this->fileName . '.' . $this->fileType;
        $file->size = 0;
        $file->mime_type = $module->getTypeInfo($this->fileType, 'mimeType');
        if (!$file->save()) {
            return false;
        }

        $file->store->setContent('');

        return $file;
    }

}
