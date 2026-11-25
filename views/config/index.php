<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\text_editor\models\forms\ConfigForm;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

/* @var $model ConfigForm */
?>
<div class="card content-card">
    <div class="card-header"><div class="card-title"><strong><?= Yii::t('TextEditorModule.base', 'Text editor') ?></strong></div></div>

    <div class="card-body">
        <h4 class="card-title"><?= Yii::t('TextEditorModule.base', 'Settings') ?></h4>
        <div class="text-body-secondary">
            <?= Yii::t('TextEditorModule.base', 'General settings for the Text Editor module.') ?>
        </div>

        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'allowNewFiles')->checkbox() ?>

        <?= Button::save()->submit() ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
