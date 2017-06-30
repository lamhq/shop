<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class Common extends AssetBundle
{
    public $sourcePath = '@app/assets/public';
    
    public $js = [
        'common.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init() {
        $baseUrl = \yii\helpers\Url::base();
        $js = sprintf("app.init('$baseUrl');");
        Yii::$app->view->registerJs($js, View::POS_END);
        return parent::init();
    }
}
