<?php
namespace shop\behaviors;

use Yii;
use app\behaviors\helpers\EmailHelper as BaseHelper;

class EmailHelper extends BaseHelper
{
	public function sendNewOrderMailToCustomer($order) {
		if (!$order->email) return false;
		$siteName = Yii::$app->params['siteName'];
		return $this->sendMail(
			[ Yii::$app->params['adminEmail'] => $siteName ],
			$order->email,
			sprintf('%s - %s #%s', $siteName, Yii::t('shop', 'Order'), $order->id),
			'@shop/mail/newOrderCustomer',
			[
				'order' => $order,
			]
		);
	}

	public function sendNewOrderMailToAdmin($order) {
		$siteName = Yii::$app->params['siteName'];
		return $this->sendMail(
			[ Yii::$app->params['autoEmail'] => $siteName ],
			Yii::$app->params['adminEmail'],
			sprintf('%s - %s #%s', $siteName, Yii::t('shop', 'Order'), $order->id),
			'@shop/mail/newOrderAdmin',
			[
				'order' => $order,
			]
		);

	}
}