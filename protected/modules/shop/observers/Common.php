<?php
namespace shop\observers;

use Yii;
use yii\base\Object;

class Common extends Object
{
	public function onBeforeAction($event) {
		$module = $event->sender;
		$module->layout = '@webroot/themes/shop/views/layouts/main';
	}
}