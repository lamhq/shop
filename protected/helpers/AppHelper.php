<?php
namespace app\helpers;
use yii;

/**
 * @author Lam Huynh <lamhq.com>
 */
class AppHelper
{
	static public function setSuccess($message) {
		Yii::$app->session->setFlash('success', $message);
	}

	static public function setError($message) {
		Yii::$app->session->setFlash('error', $message);
	}

	static public function getPageTitle($text) {
		$t = array_filter([ $text, Yii::$app->params['siteName'] ]);
		return implode(' | ', $t);
	}

	/**
	 * Return a named singleton value. Its value will be generated on the first run
	 * 
	 * @param  string $name name of the value
	 * @param  Closure $func anonymous function used to generate the value
	 * @return mixed the value
	 */
	static public function singleton($name, $func) {
		$name = 'singleton-'.$name;
		if (!isset(Yii::$app->params[$name])) {
			Yii::$app->params[$name] = $func();
		}
		return Yii::$app->params[$name];
	}
}
