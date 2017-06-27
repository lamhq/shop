<?php
namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Application;
use yii\helpers\ArrayHelper;

class Setting extends Behavior
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
		// merge local setting file to application params
		$params = Yii::$app->params;
		$params = array_merge($params, Yii::$app->helper->getLocalSetting());

		// apply setting for mail
		if ( $params['mailProtocol']=='smtp' ) {
			Yii::configure(Yii::$app, [
				'components' => [
					'mailer' => [
						'class' => 'yii\swiftmailer\Mailer',
						'viewPath' => '@app/mail',
						'useFileTransport' => false,
						'textLayout' => false,
						'transport' => [
							'class' => 'Swift_SmtpTransport',
							'host' => $params['mailSmtpHost'],
							'username' => $params['mailSmtpUser'],
							'password' => $params['mailSmtpPassword'],
							'port' => $params['mailSmtpPort'],
							'encryption' => 'tls',
						],
					],
				],
			]);			
		}
		Yii::$app->params = $params;
	}

}