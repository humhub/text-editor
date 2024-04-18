<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\text_editor\models\forms\ConfigForm;
use humhub\widgets\Button;
use yii\bootstrap\ActiveForm;

/* @var $model ConfigForm */
?>
<div class="panel panel-default">
    <div class="panel-heading"><strong><?= Yii::t('TextEditorModule.base', 'Text editor') ?></strong></div>

    <div class="panel-body">
        <h4><?= Yii::t('TextEditorModule.base', 'Settings') ?></h4>
        <div class="help-block">
            <?= Yii::t('TextEditorModule.base', 'General settings for the Text Editor module.') ?>
        </div>

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'allowNewFiles')->checkbox() ?>

        <?= Button::save()->submit() ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
