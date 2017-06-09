<?php

namespace shop\modules\customer;

use Yii;
use yii\base\Controller;

class Module extends \yii\base\Module {

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

		// setup access control filter
		$this->on(Controller::EVENT_BEFORE_ACTION, function($event) {
			$accessRules = [
				// guest
				[
					'allow' => false,
					'roles' => ['?'],
				],
				// user
				[
					'allow' => true,
					'roles' => ['@'],
				],
			];
			Yii::$app->controller->attachBehavior('access', [
				'class' => 'yii\filters\AccessControl',
				'rules'=> $accessRules,
			]);
		});
	}
}
