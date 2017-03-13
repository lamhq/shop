<?php
Yii::setAlias('@bc', realpath(__DIR__));

return [
	'modules' => [
		'bc' => [
			'class' => 'bc\Module',
			'modules'=>[
				'admin'=>['class' => 'bc\modules\admin\Module'],
			]
		],
	],
	'components' => [
		'i18n' => [
			'translations' => [
				'bc' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => __DIR__ . '/messages',
					'sourceLanguage' => 'en-US',
				],
			]
		]
	],
	'params' => [
		'accessRules' => [
			[
				'allow' => true,
				'controllers' => ['bc/admin/car'],
				'roles' => ['@'],
			],
		],
	]
];