<?php
namespace shop\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Application;

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
		var_dump($event->sender);die;
	}
}