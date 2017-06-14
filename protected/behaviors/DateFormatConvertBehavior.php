<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

/**
 * DateFormatConvertBehavior automatically convert date value of one or multiple attributes to other format when displaying and saving
 *
 * To use DateFormatConvertBehavior, configure the [[attributes]] property which should specify the list of date attributes
 * that need to be updated. Then configure 
 * [[displayFormat]] and [[storageFormat]] property with a PHP date format
 * For example,
 *
 * ```php
 * use app\behaviors\DateFormatConvertBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => DateFormatConvertBehavior::className(),
 *             'attributes' => ['published_date', 'custom_date'],
 *             'displayFormat' => 'd/m/Y',
 *             'storageFormat' => 'Y-m-d'
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Lam Huynh <daibanglam@gmail.com>
 */
class DateFormatConvertBehavior extends Behavior
{
	/**
	 * @var array list of date attributes that are to be automatically converted to 
	 * [[displayFormat]] and [[storageFormat]] when loadind and saving from/to database
	 */
	public $attributes = [];
 
	/**
	 * @var string the date format used when displaying in application
	 */
	public $displayFormat;

	/**
	 * @var string the date format used when storing in database
	 */
	public $storageFormat;


	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'saving',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'saving',
			ActiveRecord::EVENT_AFTER_FIND => 'loading',
		];
	}

	/**
	 * Convert attribute value from display format to storage format
	 * @param Event $event
	 */
	public function saving($event)
	{
		$model = $this->owner;
		foreach ($this->attributes as $attribute) {
			$model->$attribute = Yii::$app->helper->convertDateTime($model->$attribute, $this->displayFormat,
				$this->storageFormat);
		}
	}

	/**
	 * Convert attribute value from display format to storage format
	 * @param Event $event
	 */
	public function loading($event)
	{
		$model = $this->owner;
		foreach ($this->attributes as $attribute) {
			$model->$attribute = Yii::$app->helper->convertDateTime($model->$attribute, $this->storageFormat,
				$this->displayFormat);
		}
	}

}
