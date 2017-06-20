<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class App extends AssetBundle
{
    public $sourcePath = '@app/assets/public';
    
    public $js = [
        'app.js',
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
