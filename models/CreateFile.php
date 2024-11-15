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
 * CreateFile is a form for creating new text-based files (Text, Log, XML)
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
     * @var string
     */
    public $fileType;

    /**
     * @var bool
     */
    public $openEditForm = true;

    /**
     * Supported file types and their corresponding MIME types
     */
    const SUPPORTED_TYPES = [
        'text' => 'text/plain',
        'log' => 'text/plain',
        'xml' => 'application/xml'
    ];

    /**
     * Supported file extensions
     */
    const FILE_EXTENSIONS = [
        'text' => '.txt',
        'log' => '.log',
        'xml' => '.xml'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['fileName', 'required'],
            ['fileName', 'string', 'max' => 255],
            ['fileName', 'validateFileName'],
            ['fileType', 'required'],
            ['fileType', 'in', 'range' => array_keys(self::SUPPORTED_TYPES)],
            ['openEditForm', 'boolean'],
        ];
    }

    /**
     * Validates the file name and ensures proper extension
     */
    public function validateFileName($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $extension = $this->getFileExtension($this->fileName);
            $expectedExtension = self::FILE_EXTENSIONS[$this->fileType];

            if ($extension && $extension !== $expectedExtension) {
                $this->addError($attribute, Yii::t('TextEditorModule.base', 
                    'Invalid file extension. Expected {expected} for {type} files.', 
                    ['expected' => $expectedExtension, 'type' => $this->fileType]
                ));
            } elseif (!$extension) {
                // Automatically append the correct extension if none provided
                $this->fileName .= $expectedExtension;
            }
        }
    }

    /**
     * Gets the file extension from a filename
     * @param string $fileName
     * @return string|null
     */
    protected function getFileExtension($fileName)
    {
        $lastDot = strrpos($fileName, '.');
        return $lastDot === false ? null : strtolower(substr($fileName, $lastDot));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fileName' => Yii::t('TextEditorModule.base', 'File Name'),
            'fileType' => Yii::t('TextEditorModule.base', 'File Type'),
            'openEditForm' => Yii::t('TextEditorModule.base', 'Edit the new file in the next step'),
        ];
    }

    /**
     * @return array
     */
    public function getFileTypeOptions()
    {
        return [
            'text' => Yii::t('TextEditorModule.base', 'Text File (.txt)'),
            'log' => Yii::t('TextEditorModule.base', 'Log File (.log)'),
            'xml' => Yii::t('TextEditorModule.base', 'XML File (.xml)'),
        ];
    }

    /**
     * Creates a new file with the specified type
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
        $file->mime_type = self::SUPPORTED_TYPES[$this->fileType];

        if (!$file->save()) {
            return false;
        }

        // Add XML declaration if creating an XML file
        $initialContent = $this->fileType === 'xml' 
            ? '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<root></root>'
            : '';

        $file->store->setContent($initialContent);
        return $file;
    }
}
