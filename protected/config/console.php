<?php
$config = yii\helpers\ArrayHelper::merge(require('_common.php'), [
	'controllerNamespace' => 'app\commands',
	/*
	'controllerMap' => [
		'fixture' => [ // Fixture generation command line.
			'class' => 'yii\faker\FixtureController',
		],
	],
	*/
]);
unset($config['defaultRoute']);
unset($config['components']['request']);
return $config;
