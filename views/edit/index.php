<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\helpers\Html;
use humhub\modules\file\models\File;
use humhub\modules\text_editor\assets\Assets;
use humhub\modules\text_editor\models\FileUpdate;
use humhub\modules\ui\form\widgets\CodeMirrorInputWidget;
use humhub\widgets\modal\Modal;
use humhub\widgets\modal\ModalButton;

/* @var $fileUpdate FileUpdate */
/* @var $file File */

Assets::register($this);
?>
<?php $form = Modal::beginFormDialog([
    'header' => Yii::t('TextEditorModule.base', '<strong>Edit file:</strong>  {fileName}', ['fileName' => Html::encode($file->file_name)]),
    'size' => Modal::SIZE_EXTRA_LARGE,
    'form' => ['acknowledge' => true],
    'footer' => ModalButton::cancel(Yii::t('TextEditorModule.base', 'Close')) .
        ModalButton::save(Yii::t('TextEditorModule.base', 'Save'))
            ->submit()
            ->action('save', null, '#text-editor-widget'),
]) ?>
    <div id="text-editor-widget" data-ui-widget="text_editor.Editor" data-ui-init>
        <?= $form->field($fileUpdate, 'newFileContent')->widget(CodeMirrorInputWidget::class)->label(false) ?>
    </div>
<?php Modal::endFormDialog() ?>
