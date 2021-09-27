<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2021 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\assets;

use yii\web\AssetBundle;
use yii\web\View;

class Assets extends AssetBundle
{
    /**
     * @inheritDoc
     */
    public $sourcePath = '@text-editor/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.text_editor.js',
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_END
    ];

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => true
    ];

}
