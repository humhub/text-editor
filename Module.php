<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor;

use humhub\modules\file\libs\FileHelper;
use humhub\modules\file\models\File;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';

    /**
     * @var array Allowed text extensions with mime types
     */
    public $extensions = [
        'txt' => 'text/plain',
        'log' => 'text/plain',
        'xml' => 'text/xml',
    ];

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

        return isset($this->extensions[$fileExtension]);
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

    public function getMimeType(string $file): ?string
    {
        $fileExtension = FileHelper::getExtension($file);
        return isset($this->extensions[$fileExtension]) ? $this->extensions[$fileExtension] : null;
    }

}
