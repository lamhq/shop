<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;

/**
 * @author Lam Huynh <lamhq.com>
 */
class AppHelper extends Behavior
{
	/**
	 * Return instance of a variable
	 * 
	 * @param  string $name name of the variable
	 * @param  Closure $func anonymous function used to construct the variable
	 * @return mixed the value
	 */
	public function getVar($name, $func) {
		$name = 'singleton-'.$name;
		if (!isset(Yii::$app->params[$name])) {
			Yii::$app->params[$name] = $func();
		}
		return Yii::$app->params[$name];
	}

	public function setSuccess($message) {
		Yii::$app->session->setFlash('success', $message);
	}

	public function setError($message) {
		Yii::$app->session->setFlash('error', $message);
	}

	/**
	 * create data for a success json response
	 * @param  string $message
	 * @param  array  $data
	 * @return array
	 */
	public function jsonSuccess($message='', $data=[]) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return array_merge($data, [
			'success'=>1,
			'message'=>$message
		]);
	}

	/**
	 * create data for an error json response
	 * @param  string $message
	 * @param  array  $data
	 * @return array
	 */
	public function jsonError($message='', $data=[]) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return array_merge($data, [
			'success'=>0,
			'message'=>$message
		]);
	}

	public function throwException($message, $status=500) {
		throw new \yii\web\HttpException($status, $message);
	}

	public function throwSaveException($model) {
		$errors = array_values($model->getFirstErrors());
		$message = sprintf('Error when saving %s: %s', get_class($model), $errors[0]);
		throw new \yii\web\HttpException(400, $message);
	}

	public function createEvent($data) {
		return new \app\components\Event($data);
	}
}
