<?php

namespace shop\modules\manage;

use Yii;
use shop\modules\manage\assets\Shop;

class Module extends \backend\Module {

	public function init()
	{
		parent::init();
		if (Yii::$app instanceof \yii\web\Application) {
			Shop::register(Yii::$app->view);
		}
	}
}