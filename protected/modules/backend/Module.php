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
		if (Yii::$app instanceof \yii\web\Application) {
			Yii::configure(Yii::$app, [
				'components' => [
					'user' => [
						'class' => 'yii\web\User',
						'identityClass' => 'backend\models\User',
						'enableAutoLogin' => true,
						'loginUrl' => ['/backend/default/login'],
					],
				],
			]);

			// set theme to use for backend
			$this->layout = '@webroot/themes/adminlte/views/layouts/main-box';
			Yii::$app->view->theme->baseUrl = '@web/themes/adminlte';
			Yii::$app->errorHandler->errorAction = '/backend/default/error';
			\app\assets\App::register(Yii::$app->view);

			// attach permission check
			$this->on(Controller::EVENT_BEFORE_ACTION, function($event) {
				Yii::$app->controller->attachBehavior('access', [
					'class' => 'yii\filters\AccessControl',
					'rules'=> Yii::$app->params['accessRules']
				]);
			});

			// set default options for ActiveForm widget
			\Yii::$container->set('yii\bootstrap\ActiveForm', [
				'layout'=>'horizontal',
				'fieldConfig' => [
					'horizontalCssClasses' => [
						'label' => 'col-sm-2',
						'wrapper' => 'col-sm-10',
						'hint' => 'col-sm-10 col-sm-offset-2',
					],
				],
			]);
		}
	}
}
