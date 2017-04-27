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
			'@shop/mail/registration-customer'
		);
	}

	public function sendRegistrationAlertEmailToAdmin($customer) {
		$siteName = Yii::$app->name;
		return $this->sendMail(
			[ Yii::$app->params['supportEmail'] => $siteName ],
			Yii::$app->params['adminEmail'],
			'New customer', 
			'@shop/mail/registration-admin', 
			[
				'customer' => $customer,
			]
		);
	}
}