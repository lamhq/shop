<?php

namespace shop\assets;

use yii\web\AssetBundle;

class Shop extends AssetBundle
{
	public $sourcePath = '@shop/assets/public';
	
	public $css = [
	];
	
	public $js = [
		'shop-frontend.js',
	];

	public $depends = [
		'app\assets\Common',
		'lamhq\yii2\asset\NotifyJs',
	];
}
