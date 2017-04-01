<?php

namespace backend;

use Yii;
use yii\base\Controller;

/**
 * backend module definition class
 */
class Module extends \yii\base\Module
{
	public $layout = 'main-box';

	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'backend\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
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

		// set theme
		Yii::$app->view->theme->pathMap
			['@backend/views'] = '@webroot/themes/adminlte/views';

		// register asset
		\backend\assets\Backend::register(Yii::$app->view);

		// setup access control filter
		$this->on(Controller::EVENT_BEFORE_ACTION, function($event) {
			Yii::$app->controller->attachBehavior('access', [
				'class' => 'yii\filters\AccessControl',
				'rules'=> Yii::$app->params['accessRules']
			]);
		});
	}
}
