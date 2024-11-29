<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\components;

use humhub\components\access\ControllerAccess;
use Yii;
use yii\web\HttpException;
use humhub\modules\file\models\File;
use humhub\components\Controller;

/**
 * BaseFileController
 *
 * @author Luke
 */
class BaseFileController extends Controller
{
    /**
     * @inheritdoc
     * Allow access to this controller without any authentication (guest access)
     */
    public $access = ControllerAccess::class;

    protected function getFile(): File
    {
        $guid = Yii::$app->request->get('guid', Yii::$app->request->post('guid'));
        $file = File::findOne(['guid' => $guid]);
        if (empty($file)) {
            throw new HttpException(404, Yii::t('TextEditorModule.base', 'Could not find requested file!'));
        }

        return $file;
    }

}
