<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\modules\text_editor\models\FileUpdate;
use Yii;
use yii\web\HttpException;
use humhub\modules\text_editor\components\BaseFileController;

class EditController extends BaseFileController
{

    /**
     * Edit the text file in modal
     * 
     * @return string
     * @throws HttpException
     */
    public function actionIndex()
    {
        /* @var $file FileUpdate */
        $file = $this->getFile(FileUpdate::class);

        if (!$file->canDelete()) {
            throw new HttpException(401, Yii::t('TextEditorModule.base', 'Insufficient permissions!'));
        }

        if (!is_writable($file->getStore()->get())) {
            throw new HttpException(403, Yii::t('TextEditorModule.base', 'File is not writable!'));
        }

        if ($file->load(Yii::$app->request->post())) {
            if ($file->save()) {
                return $this->asJson(['result' => Yii::t('TextEditorModule.base', 'Content of the file :fileName has been updated.', [':fileName' => '"' . $file->file_name . '"'])]);
            } else {
                return $this->asJson(['error' => Yii::t('TextEditorModule.base', 'File :fileName could not be updated.', [':fileName' => '"' . $file->file_name . '"'])]);
            }
        }

        return $this->renderAjax('index', [
            'file' => $file,
        ]);
    }

}
