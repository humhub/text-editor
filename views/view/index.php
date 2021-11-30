<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\libs\Html;
use humhub\modules\file\models\File;
use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;

/* @var $file File */
?>

<?php ModalDialog::begin([
        'header' => Yii::t('TextEditorModule.base', '<strong>View file:</strong>  {fileName}', ['fileName' => Html::encode($file->file_name)]),
        'options' => ['style' => 'width:95%'],
    ]) ?>
    <div class="modal-body">
        <pre><?= htmlentities(file_get_contents($file->getStore()->get())) ?></pre>
        <div class="clearfix"></div>
    </div>

    <div class="modal-footer">
        <hr />
        <?= ModalButton::cancel(Yii::t('base', 'Close'))->right() ?>
    </div>

<?php ModalDialog::end(); ?>