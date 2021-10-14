<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\text_editor\assets\Assets;
use humhub\widgets\Button;
use humhub\widgets\ModalDialog;
use yii\web\View;

/* @var View $this */
/* @var array $types */

Assets::register($this);
?>

<?php ModalDialog::begin(['header' => Yii::t('TextEditorModule.base', '<strong>Create</strong> file')]); ?>
<div class="modal-body">
    <div><?= Yii::t('TextEditorModule.base', 'Please select a file type.') ?></div>
    <ul class="text-editor-types">
        <?php foreach ($types as $type => $data) : ?>
            <li><?= Button::asLink($data['title'], false)
                ->action('ui.modal.load', ['file', 'type' => $type])
                ->cssClass('text-editor-type ' . $type)
                ->icon($data['icon']);
            ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix"></div>
</div>
<?php ModalDialog::end(); ?>
