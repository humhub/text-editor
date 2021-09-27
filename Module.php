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
    /**
     * @var string[] allowed text extensions
     */
    public $textExtensions = ['txt', 'log', 'xml'];

    /**
     * Check the file type is supported by this module
     *
     * @param $file
     * @return bool
     */
    public function isSupportedType($file): bool
    {
        $fileExtension = FileHelper::getExtension($file);

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

}
