<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\modules\text_editor\components\BaseFileController;
use humhub\modules\text_editor\Module;
use Yii;
use yii\web\HttpException;

class ViewController extends BaseFileController
{
    /**
     * @inheritdoc
     * @var Module
     */
    public $module;

    /**
     * View the text file in modal
     *
     * @return string
     * @throws HttpException
     */
    public function actionIndex()
    {
        $file = $this->getFile();

        if (!$this->module->isSupportedType($file) || !$file->canView()) {
            throw new HttpException(
                Yii::$app->user->isGuest ? 401 : 403,
                Yii::t('TextEditorModule.base', 'Insufficient permissions!'),
            );
        }

        if (!$file->store->has()) {
            throw new HttpException(403, Yii::t('TextEditorModule.base', 'File is not readable!'));
        }

        return $this->renderAjax('index', [
            'file' => $file,
        ]);
    }

}
