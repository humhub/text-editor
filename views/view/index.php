<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\helpers\Html;
use humhub\modules\file\models\File;
use humhub\widgets\modal\Modal;
use humhub\widgets\modal\ModalButton;

/* @var $file File */
?>
<?php Modal::beginDialog([
    'header' => Yii::t('TextEditorModule.base', '<strong>View file:</strong>  {fileName}', ['fileName' => Html::encode($file->file_name)]),
    'size' => Modal::SIZE_EXTRA_LARGE,
    'footer' => ModalButton::cancel(Yii::t('base', 'Close')),
]) ?>
    <pre><?= htmlentities(file_get_contents($file->getStore()->get())) ?></pre>
<?php Modal::endDialog() ?>
