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
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;

/* @var $file FileUpdate */

Assets::register($this);
?>

<?php ModalDialog::begin([
    'header' => Yii::t('TextEditorModule.base', '<strong>Edit</strong> file', ['fileName' => Html::encode($file->file_name)]),
    'options' => ['style' => 'width:95%'],
]) ?>
    <div data-ui-widget="text_editor.Editor" data-ui-init>

        <?php $form = ActiveForm::begin(['method' => 'post']) ?>
        <div class="modal-body">
            <h3 style="padding-top:0px;margin-top:0px"><?= Html::encode($file->file_name) ?></h3>
            <br/>

            <?= $form->field($file, 'newFileContent')->textarea(['rows' => 20])->label(false) ?>

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