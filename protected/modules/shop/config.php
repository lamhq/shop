<?php
/**
 * this config file will be merged with application global config
 */

Yii::setAlias('@shop', realpath(__DIR__));

return [
	'defaultRoute'=>'shop',
	'modules' => [
		'shop' => [
			'class' => 'shop\Module',
			'modules'=>[
				'customer'=>['class' => 'shop\modules\customer\Module'],
				'manage'=>['class' => 'shop\modules\manage\Module'],
			],
		],
	],
	'components' => [
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'shop\models\Customer',
			'enableAutoLogin' => true,
			'loginUrl' => ['/shop/default/login'],
		],
		'i18n' => [
			'translations' => [
				'shop' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__ . '/messages',
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
					'pattern' => 'danh-muc/<path:.*>',
					'route' => '/shop/category/view',
					'suffix' => '.html',
				],
				[
					'pattern' => 'san-pham/<path:.*>',
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
				'controllers' => [
					'shop/manage/product',
					'shop/manage/category',
				],
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
		],	// events
	]
];