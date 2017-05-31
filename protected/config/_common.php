<?php
$config = [
	'id' => 'yii2core',
	'name' => 'Yii2 Core Project',
	'vendorPath' => __DIR__ . '/../../vendor',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'language'=>'vi-VN',
	'sourceLanguage'=>'en-US',
	'as observable' => [ 'class'=>'app\behaviors\Observable', ],
	'params' => [
		'siteName' => 'Shop',
		'metaDescription' => 'meta description',
		'metaKeyword' => 'meta tags, meta keys, seo tag',
		'adminEmail' => 'mailer@local.app',
		'supportEmail' => 'ubuntu@local.app',
		'phone' => '0164 785 4321',
		'logo' => 'logo.png',
		'favicon' => 'favicon.png',
		'storagePath' => 'storage',
		'defaultPageSize' => 30,
		'user.passwordResetTokenExpire' => 3600,
		'cookieLifeTime' => 3600,
	],
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),
			'username' => getenv('DB_USERNAME'),
			'password' => getenv('DB_PASSWORD'),
			'tablePrefix' => 'ms_',
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
				'app' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__ . '/../messages',
				],
			]
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
		'view' => [
			'as bodyClass' => [
				'class' => 'app\behaviors\BodyClass',
			],
			'theme' => [
				'basePath'=> '@app/views',
			],
		],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '6548',
		],
		'assetManager' => [
			'hashCallback' => function ($path) {
				$p = dirname($path);
				// make user friendly path
				$s2 = basename($p);
				$s1 = basename(dirname($p));
				return "$s1-$s2";
			}
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
		$config = \yii\helpers\ArrayHelper::merge($config, include($configFile));
	}
}

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['*'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['*'],
	];
}

return $config;