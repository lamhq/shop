<?php
namespace shop\observers;

use Yii;
use yii\base\Object;

class Common extends Object
{
	public function onBeforeAction($event) {
		$module = $event->sender;
		// set theme for frontend app
		if (Yii::$app instanceof \yii\web\Application) {
			$module->layout = '@webroot/themes/shop/views/layouts/main';
			$theme = $module->view->theme;
			$theme->baseUrl = '@web/themes/shop';
		}
	}
}