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
			$this->layout = '@webroot/themes/shop/views/layouts/main';
			Yii::$app->view->theme->baseUrl = '@web/themes/shop';
			Yii::$app->errorHandler->errorAction = '/frontend/default/error';
		}
	}
}
