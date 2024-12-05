<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\components\Controller;
use humhub\modules\file\libs\FileHelper;
use humhub\modules\text_editor\models\CreateFile;
use humhub\modules\text_editor\Module;
use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;

class CreateController extends Controller
{
    /**
     * @inheritdoc
     * @var Module
     */
    public $module;

    public function actionIndex()
    {
        if (!$this->module->canCreate()) {
            throw new ForbiddenHttpException('Creation of new text files is not allowed!');
        }

        $model = new CreateFile();

        // Check if it's an AJAX request but not POST (initial modal load)
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPost) {
            return $this->renderAjax('index', [
                'model' => $model,
                'fileTypeOptions' => $model->getFileTypeOptions()
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            // Validate file type
            if (!array_key_exists($model->fileType, CreateFile::SUPPORTED_TYPES)) {
                throw new BadRequestHttpException('Unsupported file type!');
            }

            if ($file = $model->save()) {
                return $this->asJson([
                    'success' => true,
                    'file' => FileHelper::getFileInfos($file),
                    'editFormUrl' => $model->openEditForm ? 
                        Url::to(['/text-editor/edit', 'guid' => $file->guid]) : false,
                ]);
            } 
            
            // For AJAX form submission errors, return AJAX response
            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => false,
                    'output' => $this->renderAjax('index', [
                        'model' => $model,
                        'fileTypeOptions' => $model->getFileTypeOptions()
                    ])
                ]);
            }
        }

        return $this->renderAjax('index', [
            'model' => $model,
            'fileTypeOptions' => $model->getFileTypeOptions()
        ]);
    }
}
