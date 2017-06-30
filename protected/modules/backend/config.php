<?php
/**
 * this config file will be merged with application global config
 */

Yii::setAlias('@backend', realpath(__DIR__));

return [
	'modules' => [
		'backend' => [
			'class' => 'backend\Module',
		],
	],
	'components' => [
		'i18n' => [
			'translations' => [
				'backend' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__ . '/messages',
				],
			]
		]
	],
	'params' => [
		'accessRules' => [
			// guest
			[
				'allow' => true,
				'controllers' => ['backend/default'],
				'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
				'roles' => ['?'],
			],
			// user
			[
				'allow' => true,
				'controllers' => [
					'backend/default',
					'backend/setting',
					'backend/slideshow',
				],
				'roles' => ['@'],
			],
		],
	]
];