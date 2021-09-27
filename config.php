<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\file\handler\FileHandlerCollection;
use humhub\modules\text_editor\Events;

return [
    'id' => 'text-editor',
    'class' => 'humhub\modules\text_editor\Module',
    'namespace' => 'humhub\modules\text_editor',
    'events' => [
        [FileHandlerCollection::class, FileHandlerCollection::EVENT_INIT, [Events::class, 'onFileHandlerCollection']],
    ],
];
