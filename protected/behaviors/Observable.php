<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Application;
use yii\helpers\ArrayHelper;

class Observable extends Behavior
{
	/**
	 * @inheritdoc
	 */
	public function events()
	{
		return [
			Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
		];
	}

	public function beforeRequest($event) {
		if ( !isset(Yii::$app->params['events']) ) return;

		foreach(Yii::$app->params['events'] as $eventName => $observers) {
			// set missing options
			foreach ($observers as &$data) {
				if ( !isset($data['runOrder']) ) {
					$data['runOrder'] = 100;
				}
			}

			// sort observers by run order
			array_multisort($observers, SORT_ASC, ArrayHelper::getColumn($observers, 'runOrder'));

			// attach event handlers
			foreach ($observers as &$data) {
				$method = $data['method'];
				unset($data['method'], $data['runOrder']);
				$observer = Yii::createObject($data);
				Yii::$app->on($eventName, [$observer, $method]);
			}
		}
	}
}