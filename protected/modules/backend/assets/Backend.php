<?php
namespace backend\assets;

use yii\web\AssetBundle;

class Backend extends AssetBundle
{
	public $sourcePath = '@backend/assets/public';
	
	public $css = [
		'backend.css'
	];
	
	public $js = [
		'backend.js',
	];

	public $depends = [
		'lamhq\yii2\asset\AdminLte',
	];
}
