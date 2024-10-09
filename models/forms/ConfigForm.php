<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\text_editor\models\forms;

use humhub\components\SettingsManager;
use humhub\modules\text_editor\Module;
use Yii;
use yii\base\Model;

/**
 * Form for Text Editor Module Settings
 */
class ConfigForm extends Model
{
    public bool $allowNewFiles = false;

    protected ?SettingsManager $settings = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->allowNewFiles = (bool) $this->getSettings()->get('allowNewFiles', false);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['allowNewFiles'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'allowNewFiles' => Yii::t('TextEditorModule.base', 'Allow creation of new text files'),
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->getSettings()->set('allowNewFiles', $this->allowNewFiles);

        return true;
    }

    protected function getSettings(): SettingsManager
    {
        if ($this->settings === null) {
            /* @var Module $module */
            $module = Yii::$app->getModule('text-editor');
            $this->settings = $module->settings;
        }

        return $this->settings;
    }
}
