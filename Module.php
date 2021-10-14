<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor;

use humhub\modules\file\libs\FileHelper;
use humhub\modules\file\models\File;
use Yii;

class Module extends \humhub\components\Module
{
    /**
     * Allowed file types
     */
    const FILE_TYPE_TXT = 'txt';
    const FILE_TYPE_LOG = 'log';
    const FILE_TYPE_XML = 'xml';

    /**
     * @var string[] allowed text extensions
     */
    public $textExtensions = [self::FILE_TYPE_TXT, self::FILE_TYPE_LOG, self::FILE_TYPE_XML];

    /**
     * Check the file type is supported by this module
     *
     * @param string|File $file File name or extension
     * @return bool
     */
    public function isSupportedType($file): bool
    {
        if (is_string($file) && strpos($file, '.') === false) {
            $fileExtension = $file;
        } else {
            $fileExtension = FileHelper::getExtension($file);
        }

        return in_array($fileExtension, $this->textExtensions);
    }

    public function canEdit(File $file): bool
    {
        return $this->isSupportedType($file) &&
            $file->canDelete() &&
            is_writable($file->getStore()->get());
    }

    public function canView(File $file): bool
    {
        return $this->isSupportedType($file) &&
            $file->canRead() &&
            is_readable($file->getStore()->get());
    }

    public function getTypesData(): array
    {
        return [
            self::FILE_TYPE_TXT => [
                'title' => Yii::t('TextEditorModule.base', 'Text'),
                'icon' => 'fa-file-text-o',
                'mimeType' => 'text/plain',
            ],
            self::FILE_TYPE_LOG => [
                'title' => Yii::t('TextEditorModule.base', 'Log'),
                'icon' => 'fa-file-o',
                'mimeType' => 'text/plain',
            ],
            self::FILE_TYPE_XML => [
                'title' => Yii::t('TextEditorModule.base', 'XML'),
                'icon' => 'fa-file-code-o',
                'mimeType' => 'text/xml',
            ],
        ];
    }

    public function getTypeInfo(string $type, string $field): ?string
    {
        $types = $this->getTypesData();
        return isset($types[$type][$field]) ? $types[$type][$field] : null;
    }

}
