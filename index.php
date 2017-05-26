<?php
require(__DIR__ . '/vendor/autoload.php');

$dotenv = new \Dotenv\Dotenv(__DIR__);
// disable .env file in production
// $env = getenv('YII_ENV');
// if(!$env || $env=='dev') {
	$dotenv->load();
// }

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV'));
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
$config = require(__DIR__ . '/protected/config/web.php');

(new yii\web\Application($config))->run();
