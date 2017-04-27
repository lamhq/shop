<?php
Yii::setAlias('@shop', realpath(__DIR__));

return [
	'defaultRoute'=>'shop',
	'modules' => [
		'shop' => [
			'class' => 'shop\Module',
			'modules'=>[
				'admin'=>['class' => 'shop\modules\admin\Module'],
			]
		],
	],
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=shop',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix' => 'ms_',
		],
		'i18n' => [
			'translations' => [
				'shop' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__ . '/messages',
					'sourceLanguage' => 'en-US',
				],
			]
		],
		'helper' => [
			'class' => 'app\components\Helper',
			'as emailHelper' => [
				'class' => 'shop\behaviors\EmailHelper'
			]
		],
	],
	'params' => [
		'accessRules' => [
			[
				'allow' => true,
				'controllers' => ['shop/admin/product'],
				'roles' => ['@'],
			],
		],
		'events' => [
			'orderPlaced' => [
				'codPayment' => [
					'class' => 'shop\observers\payment\Cod',
					'method' => 'onOrderPlaced',
				]
			]
		]
	]
];