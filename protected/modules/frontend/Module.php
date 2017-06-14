<?php

namespace frontend;

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
					'errorHandler' => [
						'class' => 'yii\web\ErrorHandler',
						'errorAction' => ['/frontend/default/error'],
					],
				],
			]);

			$this->layout = '@webroot/themes/shop/views/layouts/main';
			Yii::$app->view->theme->baseUrl = '@web/themes/shop';
		}
	}
}
