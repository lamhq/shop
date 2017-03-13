<?php
$config = yii\helpers\ArrayHelper::merge(require('common.php'), [
	'id' => 'basic-console',
	'controllerNamespace' => 'app\commands',
	'components' => [
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
	],
	/*
	'controllerMap' => [
		'fixture' => [ // Fixture generation command line.
			'class' => 'yii\faker\FixtureController',
		],
	],
	*/
]);

return $config;
