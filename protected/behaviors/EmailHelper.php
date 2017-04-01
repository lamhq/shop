<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;

class EmailHelper extends Behavior
{
	public function sendMail($from, $to, $subject, $view, $params=[]) {
		return Yii::$app->mailer->compose($view, $params)
			->setFrom($from)
			->setTo($to)
			->setSubject($subject)
			->send();
	}
}