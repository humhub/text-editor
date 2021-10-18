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
        $newFile->size = strlen($this->newFileContent);

        if (!$this->file->replaceWithFile($newFile)) {
            return false;
        }

        $newFile->store->setContent($this->newFileContent);
        return true;
    }

}
