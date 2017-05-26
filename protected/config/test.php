<?php
$config = yii\helpers\ArrayHelper::merge(require('_common.php'), [
	'components' => [
		'db' => [
			'dsn' => 'mysql:host=127.0.0.1;dbname=shop_test',
		],
		'mailer' => [
			'useFileTransport' => true,
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
