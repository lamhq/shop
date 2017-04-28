<?php
namespace shop\behaviors;

use Yii;
use app\behaviors\helpers\EmailHelper as BaseHelper;

class EmailHelper extends BaseHelper
{
	public function sendRegistrationSuccessEmailToCustomer($customer) {
		$siteName = Yii::$app->name;
		return $this->sendMail(
			[ Yii::$app->params['supportEmail'] => $siteName ],
			$customer->email,
			$siteName.' - Thank you for registering',
			'@shop/mail/registrationCustomer'
		);
	}

	public function sendRegistrationAlertEmailToAdmin($customer) {
		$siteName = Yii::$app->name;
		return $this->sendMail(
			[ Yii::$app->params['supportEmail'] => $siteName ],
			Yii::$app->params['adminEmail'],
			'New customer', 
			'@shop/mail/registrationAdmin', 
			[
				'customer' => $customer,
			]
		);
	}

	public function sendNewOrderMailToCustomer($order) {
		if (!$order->email) return false;
		$siteName = Yii::$app->name;
		return $this->sendMail(
			[ Yii::$app->params['supportEmail'] => $siteName ],
			$order->email,
			$siteName.' - Order '.$order->id,
			'@shop/mail/newOrderCustomer',
			[
				'order' => $order,
			]
		);
	}

	public function sendNewOrderMailToAdmin($order) {
		$siteName = Yii::$app->name;
		return $this->sendMail(
			[ Yii::$app->params['supportEmail'] => $siteName ],
			Yii::$app->params['adminEmail'],
			$siteName.' - Order '.$order->id,
			'@shop/mail/newOrderAdmin',
			[
				'order' => $order,
			]
		);

	}
}