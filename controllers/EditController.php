<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\modules\text_editor\components\BaseFileController;
use humhub\modules\text_editor\Module;
use humhub\modules\text_editor\models\FileUpdate;
use Yii;
use yii\web\HttpException;

class EditController extends BaseFileController
{
    /**
     * @inheritdoc
     * @var Module
     */
    public $module;

    /**
     * Edit the text file in modal
     *
     * @return string
     * @throws HttpException
     */
    public function actionIndex()
    {
        $file = $this->getFile();

        if (!$this->module->canEdit($file)) {
            throw new HttpException(
                Yii::$app->user->isGuest ? 401 : 403,
                Yii::t('TextEditorModule.base', 'Insufficient permissions!'),
            );
        }

        $fileUpdate = new FileUpdate(['file' => $file]);

        if ($fileUpdate->load(Yii::$app->request->post())) {
            if ($fileUpdate->save()) {
                return $this->asJson(['result' => Yii::t('TextEditorModule.base', 'Content of the file :fileName has been updated.', [':fileName' => '"' . $file->file_name . '"'])]);
            } else {
                return $this->asJson(['error' => Yii::t('TextEditorModule.base', 'File :fileName could not be updated.', [':fileName' => '"' . $file->file_name . '"'])]);
            }
        }

        return $this->renderAjax('index', [
            'fileUpdate' => $fileUpdate,
            'file' => $file,
        ]);
    }

}
