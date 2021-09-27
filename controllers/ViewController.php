<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use Yii;
use yii\web\HttpException;
use humhub\modules\text_editor\components\BaseFileController;

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

        if (!is_readable($file->getStore()->get())) {
            throw new HttpException(403, Yii::t('TextEditorModule.base', 'File is not readable!'));
        }

        return $this->renderAjax('index', [
            'file' => $file,
        ]);
    }

}
