<?php
Yii::setAlias('@shop', realpath(__DIR__));

return [
	'defaultRoute'=>'shop',
	'modules' => [
		'shop' => [
			'class' => 'shop\Module',
			// 'modules'=>[
			// 	'admin'=>['class' => 'shop\modules\admin\Module'],
			// ],
		],
	],
	'components' => [
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
			'as emailHelper' => ['class' => 'shop\behaviors\EmailHelper',],
			'as urlHelper' => ['class' => 'shop\behaviors\UrlHelper'],
		],
		'urlManager' => [
			'rules' => [
				[
					'pattern' => 'danh-muc/<slug:.*>',
					'route' => '/shop/category/view',
					'suffix' => '.html',
				],
				[
					'pattern' => 'san-pham/<slug:.*>',
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