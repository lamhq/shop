<?php
namespace shop\observers\payment;

use Yii;
use yii\base\Object;

class Cod extends Object
{
	public function onOrderPlaced($event) {
	}

	public function onCollectPaymentMethod($event) {
		$data = &$event->triggerData;
		$data[] = [
			'title'	=> 'Cash On Delivery',
			'code'	=> 'cod',
		];
	}

}