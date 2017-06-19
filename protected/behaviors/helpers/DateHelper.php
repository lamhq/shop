<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;

/**
 * @author Lam Huynh <lamhq.com>
 */
class DateHelper extends Behavior
{
	/**
	 * Get datetime format string to use in various places
	 * 
	 * @param  string $place place to use date format
	 * - php : php date() function
	 * - yii : Yii::$app->formatter->asDate()
	 * - datepicker : date format in datepicker (https://github.com/Eonasdan/bootstrap-datetimepicker)
	 * - db : date format for storing in database
	 * @return string
	 */
	public function getDateFormat($place='php') {
		$result = '';
		switch ($place) {
			case 'php':
				$result = 'd-m-Y H:i';
				break;

			case 'datepicker':	// day-month-year hour-minute
				$result = 'DD-MM-YYYY HH:mm';
				break;
			
			case 'yii':
				$result = 'php:d-m-Y H:i';
				break;

			case 'db':
				$result = 'Y-m-d H:i:s';
				break;

			case 'datepicker2':	// day-month-year
				$result = 'DD-MM-YYYY';
				break;
			
			case 'php2':
				$result = 'd-m-Y';
				break;

			case 'db2':
				$result = 'Y-m-d';
				break;
		}
		return $result;
	}
	
	/**
	 * convert a datetime value used in application to datetime value stored in database, 
	 * timezone conversion included
	 * @param  string $value String representing the time. 
	 * @return string the formatted result in Y-m-d H:i:s format
	 */
	public function toDbDatetime($value) {
		$f = str_replace('php:', '', $this->getAppDatetimeFormat());
		$t = \DateTime::createFromFormat( $f, $value, new \DateTimeZone(Yii::$app->timezone) );
		if (!$t) return null;
		$t->setTimezone(new \DateTimeZone(Yii::$app->formatter->defaultTimeZone));
		return $t->format('Y-m-d H:i:s');
	}

	/**
	 * convert a datetime value stored in database to datetime value used in application, 
	 * timezone conversion included
	 * @param  string $value String representing the time. http://www.yiiframework.com/doc-2.0/yii-i18n-formatter.html#asDatetime%28%29-detail
	 * @return string the formatted result.
	 */
	public function toAppDatetime($value) {
		return Yii::$app->formatter->asDateTime($value);
	}

	public function convertDateTime($value, $srcFormat, $dstFormat) {
		if (in_array($value, ['0000-00-00', null, ''])) return null;
		$t = \DateTime::createFromFormat($srcFormat, $value);
		return $t ? $t->format($dstFormat) : null;
	}
}
