<?php
Yii::setAlias('@shop', realpath(__DIR__));

return [
	'defaultRoute'=>'shop',
	'modules' => [
		'shop' => [
			'class' => 'shop\Module',
			'modules'=>[
				'admin'=>['class' => 'shop\modules\admin\Module'],
			],
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
			'as emailHelper' => [
				'class' => 'shop\behaviors\EmailHelper'
			],
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				[
					'pattern' => 'cat/<slug:.*>',
					'route' => '/shop/category/view',
					'suffix' => '.html',
				],
				[
					'pattern' => 'prod/<slug:.*>',
					'route' => '/shop/product/view',
					'suffix' => '.html',
				],
			],
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
					'runOrder' => 10,
				],
			],
			'collectPrice' => [
				'subTotal' => [
					'class' => 'shop\observers\price\SubTotal',
					'method' => 'onCollectPrice',
					'runOrder' => 10,
				],
				'total' => [
					'class' => 'shop\observers\price\Total',
					'method' => 'onCollectPrice',
					'runOrder' => 20,
				],
			],
			'collectPaymentMethod' => [
				'cod' => [
					'class' => 'shop\observers\payment\Cod',
					'method' => 'onCollectPaymentMethod',
					'runOrder' => 10,
				],
			],
			'afterCheckout' => [
				'cod' => [
					'class' => 'shop\observers\payment\Cod',
					'method' => 'onAfterCheckout',
					'runOrder' => 10,
				],
			],
			'beforeAction' => [
				'common' => [
					'class' => 'shop\observers\Common',
					'method' => 'onBeforeAction',
					'runOrder' => 10,
				],
			],
		],	// events
	]
];