<?php

namespace shop;
use Yii;
use yii\base\Controller;

class Module extends \yii\base\Module {

	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'shop\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->applySettingForWebApp();
	}

	/**
	 * reconfigure application in runtime
	 */
	public function applySettingForWebApp() {
		$this->layout = '@webroot/themes/shop/views/layouts/main';
	}
}
