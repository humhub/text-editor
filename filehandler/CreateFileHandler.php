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
 * CreateFileHandler provides the creating of a text file
 *
 * @author Luke
 */
class CreateFileHandler extends BaseFileHandler
{

    /**
     * @inheritdoc
     */
    public function getLinkAttributes()
    {
        return [
            'label' => Yii::t('TextEditorModule.base', 'Create file <small>(Text, Log, XML)</small>'),
            'data-action-url' => Url::to(['/text-editor/create']),
            'data-action-click' => 'ui.modal.load',
            'data-modal-id' => 'texteditor-modal',
            'data-modal-close' => ''
        ];
    }

}
