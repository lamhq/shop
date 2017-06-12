<?php

namespace backend;

use Yii;
use yii\base\Controller;

/**
 * backend module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->applySettingForWebApp();
	}

	public function applySettingForWebApp() {
		if (!Yii::$app instanceof \yii\web\Application) return;
		
		// change identity class
		\Yii::configure(Yii::$app, [
			'components' => [
				'user' => [
					'class' => 'yii\web\User',
					'identityClass' => 'backend\models\User',
					'enableAutoLogin' => true,
					'loginUrl' => ['/backend/default/login'],
				],
			],
		]);

		$this->layout = '@webroot/themes/adminlte/views/layouts/main-box';

		// setup access control filter
		$this->on(Controller::EVENT_BEFORE_ACTION, function($event) {
			Yii::$app->controller->attachBehavior('access', [
				'class' => 'yii\filters\AccessControl',
				'rules'=> Yii::$app->params['accessRules']
			]);
		});
	}
}
