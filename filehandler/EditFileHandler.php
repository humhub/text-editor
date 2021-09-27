<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\filehandler;

use humhub\modules\file\handler\BaseFileHandler;
use Yii;
use yii\helpers\Url;

/**
 * EditFileHandler provides the edit of a text file
 *
 * @author Luke
 */
class EditFileHandler extends BaseFileHandler
{

    /**
     * @inheritdoc
     */
    public function getLinkAttributes()
    {
        return [
            'label' => Yii::t('TextEditorModule.base', 'Edit'),
            'data-action-url' => Url::to(['/text-editor/edit', 'guid' => $this->file->guid]),
            'data-action-click' => 'ui.modal.load',
        ];
    }

}
