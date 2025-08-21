<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\components\View;
use humhub\modules\text_editor\assets\Assets;
use humhub\modules\text_editor\models\CreateFile;
use humhub\widgets\modal\Modal;
use humhub\widgets\modal\ModalButton;

/* @var View $this */
/* @var CreateFile $model */

Assets::register($this);
?>
<?php $form = Modal::beginFormDialog([
    'header' => Yii::t('TextEditorModule.base', '<strong>Create</strong> file'),
    'footer' => ModalButton::save()->submit()->action('text_editor.createSubmit'),
]) ?>
    <?= $form->field($model, 'fileName')->textInput(['autofocus' => '']) ?>
    <?= $form->field($model, 'openEditForm')->checkbox() ?>
<?php Modal::endFormDialog() ?>
