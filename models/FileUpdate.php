<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\models;

use humhub\modules\file\models\File;
use yii\base\Model;

/**
 * FileUpdate model is used to update a file content by string
 * 
 * @author Luke
 */
class FileUpdate extends Model
{

    /**
     * @var File File for updating its content
     */
    public $file;

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
    public function init()
    {
        $this->newFileContent = file_get_contents($this->file->getStore()->get());
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newFileContent'], 'safe'],
        ];
    }

    /**
     * Save the updated File content
     *
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $newFile = new File();
        $newFile->object_model = $this->file->object_model;
        $newFile->object_id = $this->file->object_id;
        $newFile->file_name = $this->file->file_name;
        $newFile->title = $this->file->title;
        $newFile->mime_type = $this->file->mime_type;
        $newFile->size = strlen($this->newFileContent);
        $newFile->show_in_stream = $this->file->show_in_stream;
        if (!$newFile->save()) {
            return false;
        }

        $newFile->store->setContent($this->newFileContent);
        if (!$this->file->replaceFileWith($newFile)) {
            return false;
        }

        $this->newFile = $newFile;

        return true;
    }

}
