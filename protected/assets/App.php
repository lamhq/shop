<?php

namespace app\assets;

use yii\web\AssetBundle;

class App extends AssetBundle
{
    public $sourcePath = '@app/assets/public';
    
    public $js = [
        'app.js',
    ];

    public $depends = [
        'lamhq\yii2\asset\NotifyJs',
    ];

    public function init() {
        $baseUrl = \yii\helpers\Url::base();
        $js = sprintf("app.init('$baseUrl');");
        \Yii::$app->view->registerJs($js);
        return parent::init();
    }
}
