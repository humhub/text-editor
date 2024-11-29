<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor;

use humhub\modules\file\models\File;
use humhub\modules\text_editor\models\forms\ConfigForm;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/text-editor/config']);
    }

    /**
     * Check the file type is supported by this module
     *
     * @param File|null $file
     * @return bool
     */
    public function isSupportedType(?File $file): bool
    {
        return $file !== null && is_string($file->mime_type) && strpos($file->mime_type, 'text/') === 0;
    }

    public function canCreate(): bool
    {
        return (new ConfigForm())->allowNewFiles;
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
