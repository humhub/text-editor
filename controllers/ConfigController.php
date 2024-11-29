<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\controllers;

use humhub\modules\admin\permissions\ManageModules;
use humhub\modules\admin\components\Controller;
use humhub\modules\text_editor\models\forms\ConfigForm;
use Yii;

class ConfigController extends Controller
{
    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [['permissions' => ManageModules::class]];
    }

    public function actionIndex()
    {
        $configForm = new ConfigForm();

        if ($configForm->load(Yii::$app->request->post()) && $configForm->save()) {
            $this->view->saved();
        }

        return $this->render('index', ['model' => $configForm]);
    }
}
