<?php
namespace shop\observers\payment;

use Yii;
use yii\helpers\Url;
use yii\base\Object;
use shop\models\Order;

class Cod extends Object
{
	public function onOrderSaved($event) {
		$order = $event->sender;
		if ($order->payment_code!='cod') return;
		
		$order->payment_method = Yii::t('shop','Cash On Delivery');
		$order->update(false, ['payment_method']);
	}

	public function onCollectPaymentMethod($event) {
		$data = &$event->triggerData;
		$data[] = [
			'title'	=> Yii::t('shop','Cash On Delivery'),
			'code'	=> 'cod',
		];
	}

	public function onAfterCheckout($event) {
		$order = $event->sender;
		if ($order->payment_code!='cod') return;
		$order->addOrderHistory(Order::STATUS_PENDING);
		$event->triggerData = ['redirect' => Url::to(['/shop/checkout/success'])];
	}

}