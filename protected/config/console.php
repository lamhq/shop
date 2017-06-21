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
$config['bootstrap'] = ['log'];

unset($config['defaultRoute']);
unset($config['components']['request']);
unset($config['components']['errorHandler']);
unset($config['modules']['debug']);
unset($config['modules']['gii']);

return $config;
