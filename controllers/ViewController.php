<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\modules\text_editor\components\BaseFileController;
use humhub\modules\text_editor\models\CreateFile;
use Yii;
use yii\web\HttpException;

class ViewController extends BaseFileController
{
    /**
     * View the text file in modal
     *
     * @return string
     * @throws HttpException
     */
    public function actionIndex()
    {
        $file = $this->getFile();

        if (!$file->canRead()) {
            throw new HttpException(401, Yii::t('TextEditorModule.base', 'Insufficient permissions!'));
        }

        $filePath = $file->getStore()->get();
        if (!is_readable($filePath)) {
            throw new HttpException(403, Yii::t('TextEditorModule.base', 'File is not readable!'));
        }

        $mimeType = $file->mime_type;

        if ($mimeType == 'application/xml') {
            Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        }

        $fileContent = file_get_contents($filePath);

        return $this->renderAjax('index', [
            'file' => $file,
            'fileContent' => $fileContent,
            'mimeType' => $mimeType,
        ]);
    }
}
