<?php
namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class Select2BootstrapTheme extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public $sourcePath = '@bower/select2-bootstrap-theme/dist';

    /**
     * {@inheritdoc}
     */
    public $js = [
    ];

    /**
     * {@inheritdoc}
     */
    public $css = [
        YII_DEBUG ? 'select2-bootstrap.css' : 'select2-bootstrap.min.css',
    ];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        \hiqdev\yii2\assets\select2\Select2Asset::class,
    ];

}
