<?php
namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class OwlCarousel2Asset extends AssetBundle
{
    public $sourcePath = '@bower/owl-carousel2/dist';

    public $js = [
        'owl.carousel.' . (YII_DEBUG ? '' : 'min.') . 'js',
    ];

    public $css = [
        'assets/owl.carousel.' . (YII_DEBUG ? '' : 'min.') . 'css',
        'assets/owl.theme.default.' . (YII_DEBUG ? '' : 'min.') . 'css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

}
