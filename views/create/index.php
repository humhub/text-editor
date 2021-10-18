<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\text_editor\assets\Assets;
use humhub\modules\text_editor\models\CreateFile;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use humhub\widgets\ModalDialog;
use yii\web\View;

/* @var View $this */
/* @var CreateFile $model */

Assets::register($this);
?>

<?php ModalDialog::begin(['header' => Yii::t('TextEditorModule.base', '<strong>Create</strong> file')]) ?>

<?php $form = ActiveForm::begin(); ?>

    <div class="modal-body">
        <?= $form->field($model, 'fileName'); ?>
        <?= $form->field($model, 'openEditForm')->checkbox(); ?>
    </div>

    <div class="modal-footer">
        <?= Button::save()->action('text_editor.createSubmit')->submit(); ?>
    </div>

<?php ActiveForm::end(); ?>

<?php ModalDialog::end(); ?>