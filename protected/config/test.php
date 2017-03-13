<?php
$config = yii\helpers\ArrayHelper::merge(require('common.php'), [
	'id' => 'basic-tests',
	'basePath' => dirname(__DIR__),    
	'language' => 'en-US',
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=yii2_basic_tests',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		],
		'mailer' => [
			'useFileTransport' => true,
		],
		'assetManager' => [            
			'basePath' => __DIR__ . '/../web/assets',
		],
		'urlManager' => [
			'showScriptName' => true,
		],
		'user' => [
			'identityClass' => 'app\models\User',
		],        
		'request' => [
			'cookieValidationKey' => 'test',
			'enableCsrfValidation' => false,
			// but if you absolutely need it set cookie domain to localhost
			/*
			'csrfCookie' => [
				'domain' => 'localhost',
			],
			*/
		],        
	],
];
return $config;
