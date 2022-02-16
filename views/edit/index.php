<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\libs\Html;
use humhub\modules\text_editor\assets\Assets;
use humhub\modules\text_editor\models\FileUpdate;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\form\widgets\CodeMirrorInputWidget;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;

/* @var $fileUpdate FileUpdate */
/* @var $file \humhub\modules\file\models\File */

Assets::register($this);
?>

<?php ModalDialog::begin([
    'header' => Yii::t('TextEditorModule.base', '<strong>Edit file:</strong>  {fileName}', ['fileName' => Html::encode($file->file_name)]),
    'options' => ['style' => 'width:95%'],
]) ?>
    <div data-ui-widget="text_editor.Editor" data-ui-init>

        <?php $form = ActiveForm::begin(['method' => 'post', 'acknowledge' => true]) ?>
        <div class="modal-body">
            <?= $form->field($fileUpdate, 'newFileContent')->widget(CodeMirrorInputWidget::class)->label(false) ?>

            <div class="clearfix"></div>
        </div>

        <div class="modal-footer">
            <hr/>
            <?= ModalButton::save(Yii::t('TextEditorModule.base', 'Save'))->submit()->action('save')->left() ?>
            <?= ModalButton::cancel(Yii::t('TextEditorModule.base', 'Close'))->right() ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
<?php ModalDialog::end(); ?>