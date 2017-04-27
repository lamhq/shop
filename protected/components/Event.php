<?php
namespace app\components;

use yii\base\Event as BaseEvent;

class Event extends BaseEvent {

	/**
	 * @var mixed the data that is passed to Event object when triggering an event.
	 * Note that this varies according to how event is created each time triggering event.
	 */
	public $triggerData;
}
