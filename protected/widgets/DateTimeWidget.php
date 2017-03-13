<?php
namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\widgets\InputWidget;

/**
 * Modified version of \trntv\yii\datetime\DateTimeWidget
 * @author Lam Huynh <daibanglam@gamil.com>
 */
class DateTimeWidget extends \trntv\yii\datetime\DateTimeWidget
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        /**
         * skip method init of \trntv\yii\datetime\DateTimeWidget
         * because it will cause bug
         */
        InputWidget::init();

        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        $this->momentDatetimeFormat = $this->momentDatetimeFormat ?: ArrayHelper::getValue(
            $this->getPhpMomentMappings(),
            $this->phpDatetimeFormat
        );
        if (!$this->momentDatetimeFormat) {
            throw new InvalidConfigException('Please set momentjs datetime format');
        }
        // Init default clientOptions
        $this->clientOptions = ArrayHelper::merge([
            'useCurrent' => true,
            'locale' => $this->locale ?: substr(Yii::$app->language, 0, 2),
            'format' => $this->momentDatetimeFormat,
        ], $this->clientOptions);

        // Init default options
        $this->options = ArrayHelper::merge([
            'class' => 'form-control',
        ], $this->options);

        if ($value !== null) {
            /**
             * modify this line: instead of using formatter->asDatetime,
             * i use the raw value of model, this fixed the bug when displaying 
             * the model attribute from the submitted form value
             */
            $this->options['value'] = array_key_exists('value', $this->options)
                ? $this->options['value']
                : $value;
                // : Yii::$app->formatter->asDatetime($value, $this->phpDatetimeFormat);
        }

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }

        $this->registerJs();
    }

}
