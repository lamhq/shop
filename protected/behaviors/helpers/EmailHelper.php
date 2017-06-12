<?php
namespace app\behaviors\helpers;

use Yii;
use yii\base\Behavior;

class EmailHelper extends Behavior
{
	public function sendMail($from, $to, $subject, $view, $params=[]) {
		return Yii::$app->mailer->compose($view, $params)
			->setFrom($from)
			->setTo($to)
			->setSubject($subject)
			->send();
	}

	public function sendRegistrationSuccessEmailToCustomer($customer) {
		if (!$customer->email) return false;
		$siteName = Yii::$app->params['siteName'];
		return $this->sendMail(
			[ Yii::$app->params['autoEmail'] => $siteName ],
			$customer->email,
			Yii::t('app', 'Registration at {0}', $siteName),
			'@app/mail/registrationCustomer'
		);
	}

	public function sendRegistrationAlertEmailToAdmin($customer) {
		$siteName = Yii::$app->params['siteName'];
		return $this->sendMail(
			[ Yii::$app->params['autoEmail'] => $siteName ],
			Yii::$app->params['adminEmail'],
			Yii::t('app', 'New customer at {0}', $siteName), 
			'@app/mail/registrationAdmin', 
			[
				'customer' => $customer,
			]
		);
	}

	public function sendRequestPasswordResetEmailToCustomer($customer) {
		$siteName = Yii::$app->params['siteName'];
		return $this->sendMail(
			[ Yii::$app->params['autoEmail'] => $siteName ],
			$customer->email,
			Yii::t('app', 'Password reset for {0}', $siteName),
			'@app/mail/passwordResetToken',
			[
				'user' => $customer
			]
		);
	}

}