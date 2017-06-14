<?php

namespace shop\modules\manage;

use Yii;
use shop\modules\manage\assets\Shop;

class Module extends \backend\Module {

	public function init()
	{
		parent::init();
		Shop::register(Yii::$app->view);
	}
}