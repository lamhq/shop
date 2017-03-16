<?php

namespace shop\assets;

use yii\web\AssetBundle;

class Shop extends AssetBundle
{
    public $sourcePath = '@shop/assets/public';
    
    public $css = [
        'shop.css'
    ];
    
    public $js = [
        'shop.js',
    ];

    public $depends = [
        'app\assets\App',
    ];
}
