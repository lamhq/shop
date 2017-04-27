<?php
$config = yii\helpers\ArrayHelper::merge(require('common.php'), [
	'id' => 'yii2core',
	'name' => 'Yii2 Core Project',
	'defaultRoute' => 'default/index',
	'components' => [
		'view' => [
			'theme' => [
				'basePath'=> '@app/views',
			]
		],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '6548',
		],
		'user' => [
			'identityClass' => 'backend\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction' => '/backend/default/error',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		'assetManager' => [
			'hashCallback' => function ($path) {
				$p = dirname($path);
				// make user friendly path
				$s2 = basename($p);
				$s1 = basename(dirname($p));
				return "$s1-$s2";
			}
		],
	]
]);

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['*'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['*'],
	];
}

return $config;
