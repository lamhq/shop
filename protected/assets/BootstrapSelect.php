<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class BootstrapSelect extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-select/dist';
    
    public $js = [
        'js/bootstrap-select.min.js',
    ];

    public $css = [
        'css/bootstrap-select.min.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
