<?php
$config = [
	'id' => 'yii2core',
	'name' => 'Yii2 Core Project',
	'vendorPath' => __DIR__ . '/../../vendor',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'language'=>'en-US',
	'sourceLanguage'=>'en-US',
	'as observable' => [ 'class'=>'app\behaviors\Observable', ],
	'as setting' => [ 'class'=>'app\behaviors\Setting', ],
	'params' => [
		'siteName' => 'Shop',
		'adminEmail' => 'mailer@local.app',
		'autoEmail' => 'ubuntu@local.app',
		'telephone' => '0164 785 4321',
		'logo' => 'logo.png',
		'favicon' => 'favicon.png',
		'metaTitle' => 'My Shop',
		'metaKeyword' => 'meta tags, meta keys, seo tag',
		'metaDescription' => 'meta description',
		'storagePath' => 'storage',
		'defaultPageSize' => 30,
		'user.passwordResetTokenExpire' => 3600,
		'cookieLifeTime' => 3600,
		'featuredProducts' => [1,2,3,4],
		'addThisLink' => '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56133df5326f44f0',
		'mailProtocol'=>'php',
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
			'as dateHelper' => ['class' => 'app\behaviors\helpers\DateHelper'],
			'as UploadHelper' => ['class' => 'app\behaviors\helpers\UploadHelper'],
		],
		'log' => [
			// 'traceLevel' => YII_DEBUG ? 3 : 0,
			'traceLevel' => 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'yii\log\FileTarget',
					'logFile' => '@runtime/logs/debug.log',
					'levels' => ['info'],
					'categories' => ['debug'],
					'logVars' => [],
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
					'route' => '/frontend/page/view',
					'suffix' => '.html',
				],
			],
		],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '6548',
		],
		'assetManager' => [
			'hashCallback' => function ($path) {
				// make user friendly path
				$suffix = sprintf('%x', crc32($path));
				$s2 = basename($path);
				$s1 = basename(dirname($path));
				return "$s1-$s2-$suffix";
			}
		],		
		'view' => [
			'as bodyClass' => [ 'class' => 'app\behaviors\BodyClass' ],
			'theme' => [ 'basePath'=> '@app/views' ],
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