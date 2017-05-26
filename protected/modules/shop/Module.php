<?php

namespace shop;
use Yii;
use yii\base\Controller;

class Module extends \yii\base\Module {

	/**
	 * @inheritdoc
	 */
	// public $controllerNamespace = 'shop\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		// custom initialization code goes here
		parent::init();

		// change identity class
		\Yii::configure(Yii::$app, [
			'components' => [
				'user' => [
					'class' => 'yii\web\User',
					'identityClass' => 'shop\models\Customer',
					'enableAutoLogin' => true,
					'loginUrl' => ['/shop/default/login'],
				],
			],
		]);

		// set theme
		Yii::$app->view->theme->pathMap
			['@shop/views'] = '@webroot/themes/shop/views';
	}
}
