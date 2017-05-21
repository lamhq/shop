<?php
$result = [
	'vendorPath' => __DIR__ . '/../../vendor',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'language'=>'vi-VN',
	'sourceLanguage'=>'en-US',
	'params' => [
		'adminEmail' => 'mailer@local.app',
		'supportEmail' => 'ubuntu@local.app',
		'siteTitle' => 'Shop',
		'storagePath' => 'storage',
		'defaultPageSize' => 30,
		'siteName' => 'Shop',
		'user.passwordResetTokenExpire' => 3600,
		'cookieLifeTime' => 3600,
	],
	'as observable' => [
		'class'=>'app\behaviors\Observable',
	],
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=bookingcar_vn',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/mail',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => false,
			'textLayout' => false,
		],
		'i18n' => [
			'translations' => [
			],
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'helper' => [
			'class' => 'app\components\Helper',
			'as appHelper' => ['class' => 'app\behaviors\helpers\AppHelper'],
			'as cmsHelper' => ['class' => 'app\behaviors\helpers\CmsHelper'],
			'as emailHelper' => ['class' => 'app\behaviors\helpers\EmailHelper'],
			'as storageHelper' => ['class' => 'app\behaviors\helpers\StorageHelper'],
			'as urlHelper' => ['class' => 'app\behaviors\helpers\UrlHelper'],
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'formatter'=>[
			'class' => 'app\components\Formatter',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				[
					'pattern' => 'trang/<slug:.*>',
					'route' => '/page/view',
					'suffix' => '.html',
				],
			],
		],
	],
];

// merge module's configuration
$mp = realpath(__DIR__ . '/../modules');
$modules = scandir($mp);
foreach ($modules as $module) {
	$configFile = sprintf('%s/%s/config.php', $mp, $module);
	if (is_dir($mp.'/'.$module) && !in_array($module, ['.', '..']) 
		&& is_file($configFile)) {
		$result = \yii\helpers\ArrayHelper::merge($result, include($configFile));
	}
}

return $result;