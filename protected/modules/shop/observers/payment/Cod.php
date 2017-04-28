<?php
namespace shop\observers\payment;

use Yii;
use yii\base\Object;
use shop\models\Order;

class Cod extends Object
{
	public function onOrderPlaced($event) {
		$order = $event->sender;
		if ($order->payment_code!='cod') return;
		
		$order->payment_method = 'Cash On Delivery';
		$order->update(false, ['payment_method']);
		$order->addOrderHistory(Order::STATUS_PENDING);
	}

	public function onCollectPaymentMethod($event) {
		$data = &$event->triggerData;
		$data[] = [
			'title'	=> 'Cash On Delivery',
			'code'	=> 'cod',
		];
	}

}