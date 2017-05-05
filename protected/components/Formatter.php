<?php
namespace app\components;

use Yii;
use yii\i18n\Formatter as BaseFormatter;

class Formatter extends BaseFormatter {

	public function asDbDatetime($value='now',$format='Y-m-d H:i:s') {
		$t = new \DateTime($value, new \DateTimeZone(Yii::$app->timezone));
		$t->setTimezone(new \DateTimeZone('UTC'));
		return $t->format($format);
	}
}
