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
use Yii;
use yii\helpers\Url;

class CreateController extends Controller
{

    public function actionIndex()
    {
        $model = new CreateFile();

        if ($model->load(Yii::$app->request->post())) {
            if ($file = $model->save()) {
                return $this->asJson([
                    'success' => true,
                    'file' => FileHelper::getFileInfos($file),
                    'editFormUrl' => $model->openEditForm ? Url::to(['/text-editor/edit', 'guid' => $file->guid]) : false,
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'output' => $this->renderAjax('index', ['model' => $model])
                ]);
            }
        }

        return $this->renderAjax('index', ['model' => $model]);
    }

}
