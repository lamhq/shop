<?php
/**
 * this config file will be merged with application global config
 */

Yii::setAlias('@frontend', realpath(__DIR__));

return [
	'modules' => [
		'frontend' => [
			'class' => 'frontend\Module',
		],
	],
	'components' => [
		'errorHandler' => [
			'errorAction' => '/frontend/default/error',
		],
	],
];