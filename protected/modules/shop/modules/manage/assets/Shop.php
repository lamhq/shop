<?php

namespace shop\modules\manage\assets;

use yii\web\AssetBundle;

class Shop extends AssetBundle
{
    public $css = [
    ];
    
    public $js = [
        'shop-backend.js',
    ];

    public $depends = [
        'app\assets\Common',
    ];

    public function init() {
    	$this->sourcePath = __DIR__ . '/public';
    }
}
