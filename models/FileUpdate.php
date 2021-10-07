<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\models;

use humhub\modules\file\models\File;

/**
 * FileUpdate model is used to set a file by string
 * 
 * @author Luke
 */
class FileUpdate extends File
{

    /**
     * @var string file content 
     */
    public $newFileContent = null;

    /**
     * @var File|null New File version after updating
     */
    public $newFile = null;

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->newFileContent = file_get_contents($this->getStore()->get());
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if ($this->newFileContent && $this->size === null) {
            $this->setFileSize();
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['newFileContent'], 'safe'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $newFile = new File();
        $newFile->object_model = $this->object_model;
        $newFile->object_id = $this->object_id;
        $newFile->file_name = $this->file_name;
        $newFile->title = $this->title;
        $newFile->size = strlen($this->newFileContent);
        $newFile->show_in_stream = $this->show_in_stream;
        if (!$newFile->save()) {
            return false;
        }

        $newFile->store->setContent($this->newFileContent);
        if (!$this->replaceFileWith($newFile)) {
            return false;
        }

        if (!parent::save($runValidation, $attributeNames)) {
            return false;
        }

        $this->newFile = $newFile;

        return true;
    }

    /**
     * Sets the file size by newFileContent
     */
    protected function setFileSize()
    {
        if (function_exists('mb_strlen')) {
            $this->size = mb_strlen($this->newFileContent, '8bit');
        } else {
            $this->size = strlen($this->newFileContent);
        }
    }

}
