<?php

namespace shop\modules\customer;

use Yii;
use yii\base\Controller;

class Module extends \frontend\Module {

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
		if (Yii::$app instanceof \yii\web\Application) {
			$this->on(Controller::EVENT_BEFORE_ACTION, function($event) {
				$accessRules = [
					[	// guest
						'allow' => false,
						'roles' => ['?'],
					],
					[	// user
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
}
