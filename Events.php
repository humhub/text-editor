<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor;

use humhub\modules\file\handler\FileHandlerCollection;
use Yii;

class Events
{

    public static function onFileHandlerCollection($event)
    {
        /* @var $collection FileHandlerCollection */
        $collection = $event->sender;

        /* @var $module Module */
        $module = Yii::$app->getModule('text-editor');

        if ($collection->type === FileHandlerCollection::TYPE_CREATE) {
            if ($module->canCreate()) {
                $collection->register(new filehandler\CreateFileHandler());
            }
            return;
        }

        if (!$module->isSupportedType($collection->file)) {
            return;
        }

        if ($collection->type == FileHandlerCollection::TYPE_EDIT && $module->canEdit($collection->file)) {
            $collection->register(new filehandler\EditFileHandler());
        }

        if ($collection->type == FileHandlerCollection::TYPE_VIEW && $module->canView($collection->file)) {
            $collection->register(new filehandler\ViewFileHandler());
        }
    }

}
